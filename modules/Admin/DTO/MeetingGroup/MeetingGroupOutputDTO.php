<?php

namespace Modules\Admin\DTO\MeetingGroup;

use Carbon\Carbon;

class MeetingGroupOutputDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {
    }
}
