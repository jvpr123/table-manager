<?php

namespace Tests\Unit\Modules\Admin\UseCase\MeetingGroup;

use Modules\Admin\Domain\Entity\MeetingGroup;
use Modules\Admin\DTO\MeetingGroup\CreateMeetingGroupInputDTO;
use Modules\Admin\DTO\MeetingGroup\MeetingGroupOutputDTO;
use Modules\Admin\Gateway\MeetingGroupGateway;
use Modules\Admin\UseCase\MeetingGroup\CreateMeetingGroupUseCase;

describe('CreateMeetingGroupUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockMeetingGroupRepository = \Mockery::mock(MeetingGroupGateway::class);
        $this->useCase = new CreateMeetingGroupUseCase($this->mockMeetingGroupRepository);

        $this->input = new CreateMeetingGroupInputDTO(
            name: 'meeting_group_name',
            description: 'meeting_group_description',
        );
    });

    it('should create a meeting group successfully', function () {
        $this->mockMeetingGroupRepository
            ->expects()
            ->create(\Mockery::type(MeetingGroup::class))
            ->once();

        $output = $this->useCase->execute($this->input);

        expect($output)->toBeInstanceOf(MeetingGroupOutputDTO::class);
        expect($output->id)->toBeString();
        expect($output->name)->toBe($this->input->name);
        expect($output->description)->toBe($this->input->description);
        expect($output->createdAt->toString())->toBe(now()->toString());
        expect($output->updatedAt->toString())->toBe(now()->toString());
    });

    it('should throw exception on creating meeting group error', function () {
        $this->mockMeetingGroupRepository
            ->expects()
            ->create(\Mockery::type(MeetingGroup::class))
            ->andThrow(new \Exception('Error creating meeting group.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new \Exception('Error creating meeting group.'));
    });
});
