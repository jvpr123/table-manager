<?php

namespace Modules\Admin\Repository;

use App\Models\Local as LocalModel;
use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Shared\Domain\ValueObject\UUID;

class LocalRepository implements LocalGateway
{
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

        return $localModel ? new Local(
            id: new UUID($localModel->uuid),
            title: $localModel->title,
            description: $localModel->description,
            createdAt: new Carbon($localModel->created_at),
            updatedAt: new Carbon($localModel->updated_at),
        ) : null;
    }

    /**
     * @return Local[]
     */
    public function list(): array
    {
        $peridosModels = LocalModel::all();

        return $peridosModels->map(fn (LocalModel $lm) => new Local(
            id: new UUID($lm->uuid),
            title: $lm->title,
            description: $lm->description,
            createdAt: new Carbon($lm->created_at),
            updatedAt: new Carbon($lm->updated_at),
        ))->toArray();
    }

    public function delete(string $id): bool
    {
        return (bool) LocalModel::where('uuid', $id)->delete();
    }
}
