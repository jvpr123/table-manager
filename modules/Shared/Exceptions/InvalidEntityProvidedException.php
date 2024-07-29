<?php

namespace Modules\Shared\Exceptions;

use Exception;

class InvalidEntityProvidedException extends Exception
{
    public function __construct(string $wrongEntity, string $rightEntity)
    {
        $wrongEntity = class_basename($wrongEntity);
        $rightEntity = class_basename($rightEntity);

        parent::__construct(printf(
            'Entity must be of type %s - %d provided instead.',
            $wrongEntity,
            $rightEntity
        ));
    }
}
