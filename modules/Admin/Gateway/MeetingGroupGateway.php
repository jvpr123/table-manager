<?php

namespace Modules\Admin\Gateway;

use Modules\Admin\Domain\Entity\MeetingGroup;

interface MeetingGroupGateway
{
    public function create(MeetingGroup $meetingGroup): void;
}
