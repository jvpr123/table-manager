<?php

namespace Modules\Admin\Domain\Entity;

use Carbon\Carbon;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\ValueObject\UUID;

class Meeting extends BaseEntity
{
    private string $date;
    private ?string $description;

    private ?string $responsibleId = null;
    private ?string $periodId = null;
    private ?string $localId = null;

    private ?Responsible $responsible = null;
    private ?Period $period = null;
    private ?Local $local = null;

    public function __construct(
        Carbon $date,
        ?string $description = null,
        ?UUID $id = null,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
        $this->setDate($date);
        $this->setDescription($description);
    }

    // Attributes
    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(Carbon $date): void
    {
        $this->date = $date->format('H:i');
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    // Relationships
    public function getResponsibleId(): ?string
    {
        return $this->responsibleId;
    }

    public function getResponsible(): ?Responsible
    {
        return $this->responsible;
    }

    public function setResponsible(Responsible $responsible): void
    {
        $this->responsible = $responsible;
        $this->responsibleId = $responsible->getId()->value;
    }

    public function unsetResponsible(): void
    {
        $this->responsible = null;
        $this->responsibleId = null;
    }

    public function getPeriodId(): ?string
    {
        return $this->periodId;
    }

    public function getPeriod(): ?Period
    {
        return $this->period;
    }

    public function setPeriod(Period $period): void
    {
        $this->period = $period;
        $this->periodId = $period->getId()->value;
    }

    public function unsetPeriod(): void
    {
        $this->period = null;
        $this->periodId = null;
    }

    public function getLocalId(): ?string
    {
        return $this->localId;
    }

    public function getLocal(): ?Local
    {
        return $this->local;
    }

    public function setLocal(Local $local): void
    {
        $this->local = $local;
        $this->localId = $local->getId()->value;
    }

    public function unsetLocal(): void
    {
        $this->local = null;
        $this->localId = null;
    }
}
