<?php

namespace Modules\Admin\DTO\Meeting;

class UpdateMeetingInputDTO
{
    public function __construct(
        public string $id,
        public string $date,
        public ?string $description,
    ) {
    }
}
