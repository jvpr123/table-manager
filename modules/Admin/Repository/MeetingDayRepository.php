<?php

namespace Modules\Admin\Repository;

use App\Models\MeetingDay as MeetingDayModel;
use Modules\Admin\Domain\Entity\MeetingDay;
use Modules\Admin\Gateway\MeetingDayGateway;

class MeetingDayRepository implements MeetingDayGateway
{
    public function create(MeetingDay $meetingDay): void
    {
        $meetingDayModel = new MeetingDayModel([
            'uuid' => $meetingDay->getId()->value,
            'name' => $meetingDay->getName(),
            'description' => $meetingDay->getDescription(),
            'created_at' => $meetingDay->getCreatedAt(),
            'updated_at' => $meetingDay->getUpdatedAt(),
        ]);

        $meetingDayModel->saveOrFail();
    }
}
