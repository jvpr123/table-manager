<?php

namespace Modules\Shared\Exceptions;

use Exception;

class EntityNotFoundException extends Exception
{
    public function __construct(string $entity, ?string $id = null)
    {
        parent::__construct("$entity not found using ID $id provided.");
    }
}
