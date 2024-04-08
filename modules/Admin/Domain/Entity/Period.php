<?php

namespace Modules\Admin\Domain\Entity;

use Carbon\Carbon;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\ValueObject\UUID;

class Period extends BaseEntity
{
    private string $time;

    public function __construct(
        Carbon $time,
        ?UUID $id = null,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
        $this->setTime($time);
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function setTime(Carbon $time): void
    {
        $this->time = $time->format('H:i');
    }
}
