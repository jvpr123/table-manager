<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\MeetingGroup as MeetingGroupModel;
use App\Models\Period;
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

describe('MeetingGroupRepository relatePeriods() unit tests', function () {
    beforeEach(function () {
        $this->periods = Period::factory()->count(5)->create();
        $this->meetingGroup = MeetingGroupModel::factory()->create();
        $this->meetingGroup->periods()->save($this->periods[0]);

        $this->repository = new MeetingGroupRepository();
    });

    it('should relate Periods to Meeting Group without detaching successfully', function () {
        $periodsIds = $this->periods->map(fn (Period $period) => $period->uuid);
        $output = $this->repository->relatePeriods(
            meetingGroupId: $this->meetingGroup->uuid,
            periodsIds: $periodsIds->toArray(),
        );

        expect($output)->toBeNull();
        expect($this->meetingGroup->periods)->toHaveCount($this->periods->count());
        $periodsIds->map(function (string $periodId) {
            $this->assertDatabaseHas('meeting_group_periods', [
                'meeting_group_id' => $this->meetingGroup->uuid,
                'period_id' => $periodId,
            ]);
        });
    });
});
