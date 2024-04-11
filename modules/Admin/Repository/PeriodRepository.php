<?php

namespace Modules\Admin\Repository;

use App\Models\Period as PeriodModel;
use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Shared\Domain\ValueObject\UUID;

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
        $periodModel = PeriodModel::where('uuid', $id)->first();

        return $periodModel ? new Period(
            id: new UUID($periodModel->uuid),
            time: $periodModel->time,
            createdAt: new Carbon($periodModel->created_at),
            updatedAt: new Carbon($periodModel->updated_at),
        ) : null;
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
