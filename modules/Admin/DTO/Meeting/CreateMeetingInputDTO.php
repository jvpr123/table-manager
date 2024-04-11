<?php

namespace Modules\Admin\DTO\Meeting;

class CreateMeetingInputDTO
{
    public function __construct(
        public string $date,
        public ?string $description = null,
    ) {
    }
}
