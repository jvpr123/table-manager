<?php

namespace Modules\Admin\DTO\Period;

class UpdatePeriodInputDTO
{
    public function __construct(public string $id, public string $time)
    {
    }
}
