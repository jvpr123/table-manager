<?php

namespace Modules\Shared\Exceptions;

use Exception;

class UndefinedEntityProperty extends Exception
{
    public function __construct(string $entity, string $property)
    {
        $entity = class_basename($entity);
        parent::__construct("$entity has no property $property in its definition.");
    }
}
