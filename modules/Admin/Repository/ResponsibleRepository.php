<?php

namespace Modules\Admin\Repository;

use App\Models\Responsible as ResponsibleModel;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\Transformer\ResponsibleTransformer;

class ResponsibleRepository implements ResponsibleGateway
{
    public function __construct(private ResponsibleTransformer $tranformer)
    {
    }

    public function create(Responsible $responsible): void
    {
        $responsibleModel = new ResponsibleModel([
            'uuid' => $responsible->getId()->value,
            'name' => $responsible->getName(),
            'created_at' => $responsible->getCreatedAt(),
            'updated_at' => $responsible->getUpdatedAt(),
        ]);

        $responsibleModel->saveOrFail();
    }

    public function update(Responsible $responsible): bool
    {
        $id = $responsible->getId()->value;
        $result = ResponsibleModel::where('uuid', $id)->update([
            'name' => $responsible->getName(),
            'updated_at' => $responsible->getUpdatedAt(),
        ]);

        return (bool) $result;
    }

    public function find(string $id): ?Responsible
    {
        $responsibleModel = ResponsibleModel::where('uuid', $id)->first();

        return $responsibleModel
            ? $this->tranformer->transform($responsibleModel)
            : null;
    }

    /**
     * @return Responsible[]
     */
    public function list(): array
    {
        $responsibleModels = ResponsibleModel::all();

        return $responsibleModels
            ->map(fn (ResponsibleModel $rm) => $this->tranformer->transform($rm))
            ->toArray();
    }

    public function delete(string $id): bool
    {
        return (bool) ResponsibleModel::where('uuid', $id)->delete();
    }
}
