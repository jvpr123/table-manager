<?php

namespace Modules\Admin\DTO\Meeting;

use Carbon\Carbon;

class MeetingOutputDTO
{
    public function __construct(
        public string $id,
        public string $date,
        public ?string $description,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {
    }
}
