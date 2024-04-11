<?php

namespace Modules\Shared\Exceptions;

use Exception;

class EntityNotFoundException extends Exception
{
    public function __construct(string $entity, ?string $id = null)
    {
        parent::__construct(printf(
            '%s not found using ID %s provided.',
            class_basename($entity),
            $id
        ));
    }
}
