<?php

namespace Modules\Admin\Domain\Entity;

use Carbon\Carbon;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\ValueObject\UUID;

class MeetingDay extends BaseEntity
{
    private string $name;
    private ?string $description;

    public function __construct(
        string $name,
        ?string $description = null,
        ?UUID $id = null,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
        $this->setName($name);
        $this->setDescription($description);
    }

    // Attributes
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
