<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\MeetingGroup as MeetingGroupModel;
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
