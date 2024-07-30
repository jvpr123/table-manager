<?php

namespace Tests\Unit\Modules\Admin\Transformer;

use App\Models\MeetingGroup as MeetingGroupModel;
use Modules\Admin\Domain\Entity\MeetingGroup;
use Modules\Admin\Transformer\MeetingGroupTransformer;

describe('MeetingGroupTransformer unit tests', function () {
    beforeEach(function () {
        $this->transformer = new MeetingGroupTransformer();

        $this->meetingGroupEntity = new MeetingGroup(
            name: 'meeting_group_name',
            description: 'meeting_group_description',
        );

        $this->meetingGroupModel = MeetingGroupModel::factory()->create([
            'uuid' => $this->meetingGroupEntity->getId()->value,
            'name' => $this->meetingGroupEntity->getName(),
            'description' => $this->meetingGroupEntity->getDescription(),
            'created_at' => $this->meetingGroupEntity->getCreatedAt(),
            'updated_at' => $this->meetingGroupEntity->getUpdatedAt(),
        ]);
    });

    it('should transform MeetingGroup model into entity successfully', function () {
        $output = $this->transformer->transform($this->meetingGroupModel);
        expect($output)->toBeInstanceOf(MeetingGroup::class);
    });
});
