<?php

namespace Tests\Unit\Modules\Admin\UseCase\MeetingGroup;

use App\Models\MeetingGroup as MeetingGroupModel;
use App\Models\Responsible as ResponsibleModel;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\DTO\MeetingGroup\RelateMeetingGroupToResponsiblesInputDTO;
use Modules\Admin\Gateway\MeetingGroupGateway;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\Transformer\MeetingGroupTransformer;
use Modules\Admin\Transformer\ResponsibleTransformer;
use Modules\Admin\UseCase\MeetingGroup\RelateMeetingGroupToResponsiblesUseCase;
use Modules\Shared\Exceptions\EntityAlreadyRelatedException;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('RelateMeetingGroupToResponsiblesUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockMeetingGroupRepository = \Mockery::mock(MeetingGroupGateway::class);
        $this->mockResponsibleRepository = \Mockery::mock(ResponsibleGateway::class);
        $this->useCase = new RelateMeetingGroupToResponsiblesUseCase(
            $this->mockMeetingGroupRepository,
            $this->mockResponsibleRepository,
        );

        $this->meetingGroup = (new MeetingGroupTransformer())->transform(MeetingGroupModel::factory()->make());
        $this->meetingGroupId = $this->meetingGroup->getId()->value;

        $this->responsibles = ResponsibleModel::factory()
            ->count(3)
            ->make()
            ->map(fn (ResponsibleModel $r) => (new ResponsibleTransformer())->transform($r));
        $this->responsiblesIds = collect($this->responsibles)->map(fn (Responsible $r) => $r->getId()->value);
    });

    it('should relate Responsibles to MeetingGroup successfully', function () {
        $this->meetingGroup->setResponsibles($this->responsibles->toArray());

        $responsibleToRelate = new Responsible(name: 'responsible_name');
        $input = new RelateMeetingGroupToResponsiblesInputDTO(
            $this->meetingGroupId,
            [$responsibleToRelate->getId()->value],
        );

        $this->mockMeetingGroupRepository
            ->expects()
            ->getMeetingGroupWithResponsibles($this->meetingGroupId)
            ->andReturn($this->meetingGroup)
            ->once();

        $this->mockResponsibleRepository
            ->expects()
            ->find($responsibleToRelate->getId()->value)
            ->andReturn($responsibleToRelate)
            ->once();

        $this->mockMeetingGroupRepository
            ->expects()
            ->toggleResponsibles(
                $this->meetingGroupId,
                [$responsibleToRelate->getId()->value]
            )
            ->once();

        $output = $this->useCase->execute($input);
        expect($output)->toBeNull();
    });

    it('should throw an exception if MeetingGroup not found', function () {
        $input = new RelateMeetingGroupToResponsiblesInputDTO(
            meetingGroupId: $id = uuid_create(),
            responsiblesIds: [],
        );

        $this->mockMeetingGroupRepository
            ->expects()
            ->getMeetingGroupWithResponsibles($id)
            ->andReturnNull()
            ->once();

        $this->useCase->execute($input);
    })->throws(EntityNotFoundException::class);

    it('should throw an exception if any Responsible not found', function () {
        $input = new RelateMeetingGroupToResponsiblesInputDTO(
            meetingGroupId: $this->meetingGroupId,
            responsiblesIds: [$id = uuid_create()],
        );

        $this->mockMeetingGroupRepository
            ->expects()
            ->getMeetingGroupWithResponsibles($this->meetingGroupId)
            ->andReturn($this->meetingGroup)
            ->once();

        $this->mockResponsibleRepository
            ->expects()
            ->find($id)
            ->andReturnNull()
            ->once();

        $this->useCase->execute($input);
    })->throws(EntityNotFoundException::class);

    it('should throw an exception if any Responsible is already related to MeetingGroup', function () {
        $this->meetingGroup->setResponsibles($this->responsibles->toArray());

        $input = new RelateMeetingGroupToResponsiblesInputDTO(
            $this->meetingGroupId,
            $this->responsiblesIds->toArray(),
        );

        $this->mockMeetingGroupRepository
            ->expects()
            ->getMeetingGroupWithResponsibles($this->meetingGroupId)
            ->andReturn($this->meetingGroup)
            ->once();

        $this->responsiblesIds->each(function (string $id, int $key) {
            $this->mockResponsibleRepository
                ->expects()
                ->find($id)
                ->andReturn($this->responsibles[$key])
                ->once();
        });

        $this->useCase->execute($input);
    })->throws(EntityAlreadyRelatedException::class);
});
