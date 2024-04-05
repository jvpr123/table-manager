<?php

namespace Modules\Admin\DTO\Local;

class CreateLocalInputDTO
{
    public function __construct(
        public string $title,
        public string $description,
    ) {
    }
}
