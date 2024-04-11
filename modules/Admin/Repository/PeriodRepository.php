<?php

namespace Modules\Admin\Repository;

use App\Models\Period as PeriodModel;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\Gateway\PeriodGateway;

class PeriodRepository implements PeriodGateway
{
    public function create(Period $period): void
    {
        $periodModel = new PeriodModel([
            'uuid' => $period->getId()->value,
            'time' => $period->getTime(),
            'created_at' => $period->getCreatedAt(),
            'updated_at' => $period->getUpdatedAt(),
        ]);

        $periodModel->saveOrFail();
    }

    public function find(string $id): ?Period
    {
        return null;
    }

    public function list(): array
    {
        return [];
    }

    public function update(Period $period): bool
    {
        return false;
    }

    public function delete(string $id): bool
    {
        return false;
    }
}
