<?php

namespace Modules\Shared\Exceptions;

use Exception;
use Modules\Shared\Domain\Entity\BaseEntity;

class EntityAlreadyRelatedException extends Exception
{
    public function __construct(BaseEntity $fatherEntity, BaseEntity $childEntity)
    {
        $father = class_basename($fatherEntity);
        $child = class_basename($childEntity);

        parent::__construct(printf(
            '%s using ID %s is already related to this %s.',
            $child,
            $childEntity->getId()->value,
            $father,
        ));
    }
}
