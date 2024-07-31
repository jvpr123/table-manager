<?php

namespace Modules\Admin\DTO\MeetingGroup;

class RelateMeetingGroupToResponsiblesInputDTO
{
    public function __construct(
        public string $meetingGroupId,
        public array $responsiblesIds,
    ) {
    }
}
