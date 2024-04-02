<?php

namespace Modules\Shared\Domain\ValueObject;

use Modules\Shared\Exceptions\InvalidUuidException;

class UUID implements ValueObjectInterface
{
    public string $value;

    public function __construct(?string $id = null)
    {
        if (!$id) {
            $this->value = uuid_create();
            return;
        }

        if (!self::validate($id)) {
            throw new InvalidUuidException();
        }

        $this->value = $id;
    }

    public static function validate(?string $id = null): bool
    {
        return !$id ? false : uuid_is_valid($id);
    }
}
