<?php

namespace Modules\Shared\Domain\Entity;

use Carbon\Carbon;
use Modules\Shared\Domain\ValueObject\UUID;
use Modules\Shared\Exceptions\InvalidEntityProvidedException;

abstract class BaseEntity
{
    private UUID $id;
    private Carbon $createdAt;
    private Carbon $updatedAt;

    public function __construct(?UUID $id = null, ?Carbon $createdAt = null, ?Carbon $updatedAt = null)
    {
        $this->id = $id ? $id : new UUID();
        $this->createdAt = $createdAt ?: now();
        $this->updatedAt = $updatedAt ?: now();
    }

    public function getId(): UUID
    {
        return $this->id;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(Carbon $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    protected function verifyEntityType(string $entityUnderValidation, string $validEntity): void
    {
        if ($entityUnderValidation !== $validEntity) {
            throw new InvalidEntityProvidedException($entityUnderValidation, $validEntity);
        }
    }
}
