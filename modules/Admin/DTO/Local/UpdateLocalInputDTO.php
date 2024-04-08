<?php

namespace Modules\Admin\DTO\Local;

class UpdateLocalInputDTO
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
    ) {
    }
}
