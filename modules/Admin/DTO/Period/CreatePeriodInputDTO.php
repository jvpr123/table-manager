<?php

namespace Modules\Admin\DTO\Period;

use Carbon\Carbon;

class CreatePeriodInputDTO
{
    public function __construct(public Carbon $time)
    {
    }
}
