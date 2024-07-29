<?php

namespace Modules\Admin\DTO\MeetingGroup;

class CreateMeetingGroupInputDTO
{
    public function __construct(
        public string $name,
        public ?string $description = null,
    ) {
    }
}
