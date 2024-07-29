<?php

namespace Modules\Admin\Repository;

use App\Models\MeetingGroup as MeetingGroupModel;
use Modules\Admin\Domain\Entity\MeetingGroup;
use Modules\Admin\Gateway\MeetingGroupGateway;

class MeetingGroupRepository implements MeetingGroupGateway
{
    public function create(MeetingGroup $meetingGroup): void
    {
        $meetingGroupModel = new MeetingGroupModel([
            'uuid' => $meetingGroup->getId()->value,
            'name' => $meetingGroup->getName(),
            'description' => $meetingGroup->getDescription(),
            'created_at' => $meetingGroup->getCreatedAt(),
            'updated_at' => $meetingGroup->getUpdatedAt(),
        ]);

        $meetingGroupModel->saveOrFail();
    }

    public function togglePeriods(string $meetingGroupId, array $periodsIds): void
    {
        MeetingGroupModel::firstWhere('uuid', $meetingGroupId)
            ->periods()
            ->toggle($periodsIds);
    }
}
