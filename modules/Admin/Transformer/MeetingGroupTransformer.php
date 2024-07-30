<?php

namespace Modules\Admin\Transformer;

use App\Models\MeetingGroup as MeetingGroupModel;
use Modules\Admin\Domain\Entity\MeetingGroup;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\Transformer\BaseTransformer;
use Modules\Shared\Domain\ValueObject\UUID;

class MeetingGroupTransformer implements BaseTransformer
{
    /**
     * @param MeetingGroupModel $meetingGroup
     * @return MeetingGroup
     */
    public function transform(object $meetingGroupModel): BaseEntity
    {
        return new MeetingGroup(
            id: new UUID($meetingGroupModel->uuid),
            name: $meetingGroupModel->name,
            description: $meetingGroupModel->description,
            createdAt: $meetingGroupModel->created_at,
            updatedAt: $meetingGroupModel->updated_at,
        );
    }
}
