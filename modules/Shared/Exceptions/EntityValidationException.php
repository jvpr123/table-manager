<?php

namespace Modules\Shared\Exceptions;

use Exception;

class EntityValidationException extends Exception
{
    public function __construct(string $entity, private array $errors)
    {
        parent::__construct("Errors found in $entity validation.");
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
