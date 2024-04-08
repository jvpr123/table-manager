<?php

namespace Modules\Admin\DTO\Period;

use Carbon\Carbon;

class PeriodOutputDTO
{
    public function __construct(
        public string $id,
        public string $time,
        public Carbon $createdAt,
        public Carbon $updatedAt,
    ) {
    }
}
