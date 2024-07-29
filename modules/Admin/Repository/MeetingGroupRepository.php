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

    public function toggleResponsibles(string $meetingGroupId, array $responsiblesIds): void
    {
        MeetingGroupModel::firstWhere('uuid', $meetingGroupId)
            ->responsibles()
            ->toggle($responsiblesIds);
    }

    public function togglePeriods(string $meetingGroupId, array $periodsIds): void
    {
        MeetingGroupModel::firstWhere('uuid', $meetingGroupId)
            ->periods()
            ->toggle($periodsIds);
    }

    public function toggleLocals(string $meetingGroupId, array $localsIds): void
    {
        MeetingGroupModel::firstWhere('uuid', $meetingGroupId)
            ->locals()
            ->toggle($localsIds);
    }
}
