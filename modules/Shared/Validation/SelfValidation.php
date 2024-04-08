<?php

namespace Modules\Shared\Validation;

use Modules\Shared\Exceptions\EntityValidationException;
use Modules\Shared\Exceptions\UndefinedEntityProperty;

trait SelfValidation
{
    protected array $errors = [];

    private function pushField(string $field): self
    {
        if (!property_exists($this, $field)) {
            throw new UndefinedEntityProperty(self::class, $field);
        }

        $this->errors[$field] = [];

        return $this;
    }

    protected function pushError(string $field, string $error): self
    {
        if (!array_key_exists($field, $this->errors)) {
            $this->pushField($field);
        }

        $this->errors[$field][] = $error;

        return $this;
    }

    public function validate(): self
    {
        if (!empty($this->errors)) {
            throw new EntityValidationException(self::class, $this->errors);
        }

        return $this;
    }
}
