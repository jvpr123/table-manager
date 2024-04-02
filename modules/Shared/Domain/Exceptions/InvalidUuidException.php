<?php

namespace Modules\Shared\Domain\Exceptions;

use Exception;

class InvalidUuidException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid UUID value provided.');
    }
}
