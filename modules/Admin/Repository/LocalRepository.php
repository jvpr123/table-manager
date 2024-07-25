<?php

namespace Modules\Admin\Repository;

use App\Models\Local as LocalModel;
use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Admin\Transformer\LocalTransformer;

class LocalRepository implements LocalGateway
{
    public function __construct(private LocalTransformer $transformer)
    {
    }

    public function create(Local $local): void
    {
        $localModel = new LocalModel([
            'uuid' => $local->getId()->value,
            'title' => $local->getTitle(),
            'description' => $local->getDescription(),
            'created_at' => $local->getCreatedAt(),
            'updated_at' => $local->getUpdatedAt(),
        ]);

        $localModel->saveOrFail();
    }

    public function update(Local $local): bool
    {
        $id = $local->getId()->value;
        $result = LocalModel::where('uuid', $id)->update([
            'title' => $local->getTitle(),
            'description' => $local->getDescription(),
            'updated_at' => $local->getUpdatedAt(),
        ]);

        return (bool) $result;
    }

    public function find(string $id): ?Local
    {
        $localModel = LocalModel::where('uuid', $id)->first();

        return $localModel
            ? $this->transformer->transform($localModel)
            : null;
    }

    /**
     * @return Local[]
     */
    public function list(): array
    {
        $peridosModels = LocalModel::all();

        return $peridosModels
            ->map(fn (LocalModel $lm) => $this->transformer->transform($lm))
            ->toArray();
    }

    public function delete(string $id): bool
    {
        return (bool) LocalModel::where('uuid', $id)->delete();
    }
}
