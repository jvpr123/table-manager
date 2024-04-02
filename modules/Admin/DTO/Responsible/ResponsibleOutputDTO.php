<?php

namespace Modules\Admin\DTO\Responsible;

use Carbon\Carbon;

class ResponsibleOutputDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {
    }
}
