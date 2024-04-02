<?php

namespace Modules\Shared\Exceptions;

use Exception;

class EntityNotFoundException extends Exception
{
    public function __construct(?string $entity = null, ?string $id = null)
    {
        parent::__construct(printf(
            '%s not found using ID %s provided.',
            $entity ?: 'Entity',
            $id
        ));
    }
}
