<?php

namespace Modules\Admin\Gateway;

use Modules\Admin\Domain\Entity\Period;

interface PeriodGateway
{
    public function create(Period $period): void;

    public function update(Period $period): bool;

    public function find(string $id): ?Period;

    /**
     * @return Period[]
     */
    public function list(): array;

    public function delete(string $id): bool;
}
