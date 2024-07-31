<?php

namespace Modules\Admin\Gateway;

use Modules\Admin\Domain\Entity\MeetingGroup;

interface MeetingGroupGateway
{
    public function create(MeetingGroup $meetingGroup): void;
    public function meetingGroupExists(string $meetingGroupId): bool;
    public function getMeetingGroupWithResponsibles(string $meetingGroupId): ?MeetingGroup;

    public function toggleResponsibles(string $meetingGroupId, array $responsiblesIds): void;
    public function togglePeriods(string $meetingGroupId, array $periodsIds): void;
    public function toggleLocals(string $meetingGroupId, array $localsIds): void;
}
