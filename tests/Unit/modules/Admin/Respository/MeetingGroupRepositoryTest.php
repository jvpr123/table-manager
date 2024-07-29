<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\Local;
use App\Models\MeetingGroup as MeetingGroupModel;
use App\Models\Period;
use App\Models\Responsible;
use Modules\Admin\Domain\Entity\MeetingGroup;
use Modules\Admin\Repository\MeetingGroupRepository;

describe('MeetingGroupRepository create() unit tests', function () {
    beforeEach(function () {
        $this->meetingGroup = new MeetingGroup(
            name: 'meeting_group_name',
            description: 'meeting_group_description',
        );

        $this->repository = new MeetingGroupRepository();
    });

    it('should register a Meeting Group in database successfully', function () {
        $output = $this->repository->create($this->meetingGroup);

        expect($output)->toBeNull();
        $this->assertDatabaseHas('meeting_groups', [
            'uuid' => $this->meetingGroup->getId()->value,
            'name' => $this->meetingGroup->getName(),
            'description' => $this->meetingGroup->getDescription(),
            'created_at' => $this->meetingGroup->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->meetingGroup->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);
    });

    it('should throw exception on MeetingGroup saving error', function () {
        expect(function () {
            MeetingGroupModel::saving(throw new \Exception('Error saving meeting group.'));
            $this->repository->create($this->meetingGroup);
        })->toThrow(new \Exception('Error saving meeting group.'));

        $this->assertDatabaseMissing('meeting_groups', ['uuid' => $this->meetingGroup->getId()->value]);
    });
});

describe('MeetingGroupRepository meetingGroupExists() unit tests', function () {
    beforeEach(function () {
        $this->meetingGroupId = MeetingGroupModel::factory()->create()->uuid;
        $this->repository = new MeetingGroupRepository();
    });

    it('should return true if Meeting Group exists', function () {
        $output = $this->repository->meetingGroupExists($this->meetingGroupId);
        expect($output)->toBeTrue();
    });

    it('should return false if Meeting Group don`t exists', function () {
        $output = $this->repository->meetingGroupExists(uuid_create());
        expect($output)->toBeFalse();
    });
});

describe('MeetingGroupRepository toggleResponsibles() unit tests', function () {
    beforeEach(function () {
        $this->meetingGroup = MeetingGroupModel::factory()->create();
        $this->responsibles = Responsible::factory()->count(2)->create();

        $this->repository = new MeetingGroupRepository();
    });

    it('should relate Periods to Meeting Group without detaching successfully', function () {
        $this->meetingGroup->responsibles()->toggle(Responsible::factory()->create());
        $responsiblesIds = $this->responsibles->map(fn (Responsible $responsible) => $responsible->uuid);

        $output = $this->repository->toggleResponsibles(
            meetingGroupId: $this->meetingGroup->uuid,
            responsiblesIds: $responsiblesIds->toArray(),
        );

        expect($output)->toBeNull();
        expect($this->meetingGroup->responsibles)->toHaveCount(3);
        $responsiblesIds->map(function (string $responsibleId) {
            $this->assertDatabaseHas('meeting_group_responsibles', [
                'meeting_group_id' => $this->meetingGroup->uuid,
                'responsible_id' => $responsibleId,
            ]);
        });
    });

    it('should unrelate Periods to Meeting Group successfully', function () {
        $responsiblesIds = $this->responsibles->map(fn (Responsible $responsible) => $responsible->uuid);
        $this->meetingGroup->responsibles()->toggle($responsiblesIds);

        $output = $this->repository->toggleResponsibles(
            meetingGroupId: $this->meetingGroup->uuid,
            responsiblesIds: $responsiblesIds->toArray(),
        );

        expect($output)->toBeNull();
        expect($this->meetingGroup->responsible)->toBeEmpty();
        $responsiblesIds->map(function (string $responsibleId) {
            $this->assertDatabaseMissing('meeting_group_responsibles', [
                'meeting_group_id' => $this->meetingGroup->uuid,
                'responsible_id' => $responsibleId,
            ]);
        });
    });
});

describe('MeetingGroupRepository togglePeriods() unit tests', function () {
    beforeEach(function () {
        $this->meetingGroup = MeetingGroupModel::factory()->create();
        $this->periods = Period::factory()->count(2)->create();

        $this->repository = new MeetingGroupRepository();
    });

    it('should relate Periods to Meeting Group without detaching successfully', function () {
        $this->meetingGroup->periods()->toggle(Period::factory()->create());
        $periodsIds = $this->periods->map(fn (Period $period) => $period->uuid);

        $output = $this->repository->togglePeriods(
            meetingGroupId: $this->meetingGroup->uuid,
            periodsIds: $periodsIds->toArray(),
        );

        expect($output)->toBeNull();
        expect($this->meetingGroup->periods)->toHaveCount(3);
        $periodsIds->map(function (string $periodId) {
            $this->assertDatabaseHas('meeting_group_periods', [
                'meeting_group_id' => $this->meetingGroup->uuid,
                'period_id' => $periodId,
            ]);
        });
    });

    it('should unrelate Periods to Meeting Group successfully', function () {
        $periodsIds = $this->periods->map(fn (Period $period) => $period->uuid);
        $this->meetingGroup->periods()->toggle($periodsIds);

        $output = $this->repository->togglePeriods(
            meetingGroupId: $this->meetingGroup->uuid,
            periodsIds: $periodsIds->toArray(),
        );

        expect($output)->toBeNull();
        expect($this->meetingGroup->periods)->toBeEmpty();
        $periodsIds->map(function (string $periodId) {
            $this->assertDatabaseMissing('meeting_group_periods', [
                'meeting_group_id' => $this->meetingGroup->uuid,
                'period_id' => $periodId,
            ]);
        });
    });
});

describe('MeetingGroupRepository toggleLocals() unit tests', function () {
    beforeEach(function () {
        $this->meetingGroup = MeetingGroupModel::factory()->create();
        $this->locals = Local::factory()->count(2)->create();

        $this->repository = new MeetingGroupRepository();
    });

    it('should relate Locals to Meeting Group without detaching successfully', function () {
        $this->meetingGroup->locals()->toggle(Local::factory()->create());
        $localsIds = $this->locals->map(fn (Local $local) => $local->uuid);

        $output = $this->repository->toggleLocals(
            meetingGroupId: $this->meetingGroup->uuid,
            localsIds: $localsIds->toArray(),
        );

        expect($output)->toBeNull();
        expect($this->meetingGroup->locals)->toHaveCount(3);
        $localsIds->map(function (string $localId) {
            $this->assertDatabaseHas('meeting_group_locals', [
                'meeting_group_id' => $this->meetingGroup->uuid,
                'local_id' => $localId,
            ]);
        });
    });

    it('should unrelate Locals to Meeting Group successfully', function () {
        $localsIds = $this->locals->map(fn (Local $local) => $local->uuid);
        $this->meetingGroup->locals()->toggle($localsIds);

        $output = $this->repository->toggleLocals(
            meetingGroupId: $this->meetingGroup->uuid,
            localsIds: $localsIds->toArray(),
        );

        expect($output)->toBeNull();
        expect($this->meetingGroup->locals)->toBeEmpty();
        $localsIds->map(function (string $localId) {
            $this->assertDatabaseMissing('meeting_group_locals', [
                'meeting_group_id' => $this->meetingGroup->uuid,
                'local_id' => $localId,
            ]);
        });
    });
});
