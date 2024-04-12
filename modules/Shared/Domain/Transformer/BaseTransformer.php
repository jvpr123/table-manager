<?php

namespace Modules\Shared\Domain\Transformer;

use Modules\Shared\Domain\Entity\BaseEntity;

interface BaseTransformer
{
    public function transform(object $model): BaseEntity;
}
