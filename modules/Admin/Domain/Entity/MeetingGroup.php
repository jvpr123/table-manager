<?php

namespace Modules\Admin\Domain\Entity;

use Carbon\Carbon;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\ValueObject\UUID;

class MeetingGroup extends BaseEntity
{
    private string $name;
    private ?string $description;

    /**
     * @var Responsible[]
     */
    private array $responsibles = [];

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

    /**
     * @return Responsible[]
     */
    public function getResponsibles(): array
    {
        return $this->responsibles;
    }

    /**
     * @param Responsible[] $responsibles
     * @return Responsible[]
     */
    public function setResponsibles(array $responsibles): array
    {
        foreach ($responsibles as $responsible) {
            $this->verifyEntityType($responsible::class, Responsible::class);
            $this->responsibles[] = $responsible;
        }

        return $this->responsibles;
    }
}
