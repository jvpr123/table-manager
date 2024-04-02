<?php

namespace Modules\Shared\Exceptions;

use Exception;

class InvalidUuidException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid UUID value provided.');
    }
}
