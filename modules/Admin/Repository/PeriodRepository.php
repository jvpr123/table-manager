<?php

namespace Modules\Admin\Repository;

use App\Models\Period as PeriodModel;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Admin\Transformer\PeriodTransformer;

class PeriodRepository implements PeriodGateway
{
    public function __construct(private PeriodTransformer $transformer)
    {
    }

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

    public function update(Period $period): bool
    {
        $id = $period->getId()->value;
        $result = PeriodModel::where('uuid', $id)->update([
            'time' => $period->getTime(),
            'updated_at' => $period->getUpdatedAt(),
        ]);

        return (bool) $result;
    }

    public function find(string $id): ?Period
    {
        $periodModel = PeriodModel::where('uuid', $id)->first();

        return $periodModel
            ? $this->transformer->transform($periodModel)
            : null;
    }

    /**
     * @return Period[]
     */
    public function list(): array
    {
        $peridosModels = PeriodModel::all();

        return $peridosModels
            ->map(fn (PeriodModel $pm) => $this->transformer->transform($pm))
            ->toArray();
    }

    public function delete(string $id): bool
    {
        return (bool) PeriodModel::where('uuid', $id)->delete();
    }
}
