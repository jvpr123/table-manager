<?php

namespace Modules\Admin\DTO\Responsible;

class UpdateResponsibleInputDTO
{
    public function __construct(public string $id, public string $name)
    {
    }
}
