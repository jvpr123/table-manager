<?php

namespace Modules\Admin\Repository;

use App\Models\MeetingGroup as MeetingGroupModel;
use App\Models\Responsible as ResponsibleModel;
use Modules\Admin\Domain\Entity\MeetingGroup;
use Modules\Admin\Gateway\MeetingGroupGateway;
use Modules\Admin\Transformer\MeetingGroupTransformer;
use Modules\Admin\Transformer\ResponsibleTransformer;

class MeetingGroupRepository implements MeetingGroupGateway
{
    public function __construct(
        private MeetingGroupTransformer $meetingGroupTransformer,
        private ResponsibleTransformer $responsibleTransformer,
    ) {
    }

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

    public function meetingGroupExists(string $meetingGroupId): bool
    {
        return (bool) MeetingGroupModel::where('uuid', $meetingGroupId)->exists();
    }

    public function getMeetingGroupWithResponsibles(string $id): ?MeetingGroup
    {
        $meetingGroupModel = MeetingGroupModel::with('responsibles')
            ->where('uuid', $id)
            ->first();

        if (!$meetingGroupModel) return null;

        $meetingGroup = $this->meetingGroupTransformer->transform($meetingGroupModel);
        $responsibles = $meetingGroupModel->responsibles->map(
            fn (ResponsibleModel $res) => $this->responsibleTransformer->transform($res)
        );
        $meetingGroup->setResponsibles($responsibles->toArray());

        return $meetingGroup;
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
