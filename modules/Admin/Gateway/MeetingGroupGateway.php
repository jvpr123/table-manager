<?php

namespace Modules\Admin\Gateway;

use Modules\Admin\Domain\Entity\MeetingGroup;

interface MeetingGroupGateway
{
    public function create(MeetingGroup $meetingGroup): void;
    public function togglePeriods(string $meetingGroupId, array $periodsIds): void;
    public function toggleLocals(string $meetingGroupId, array $localsIds): void;
}
