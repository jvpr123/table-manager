<?php

namespace Modules\Admin\Gateway;

use Modules\Admin\Domain\Entity\MeetingDay;

interface MeetingDayGateway
{
    public function create(MeetingDay $meetingDay): void;
}
