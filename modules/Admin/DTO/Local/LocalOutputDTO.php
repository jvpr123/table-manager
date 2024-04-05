<?php

namespace Modules\Admin\DTO\Local;

use Carbon\Carbon;

class LocalOutputDTO
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {
    }
}
