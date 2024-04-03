<?php

namespace Modules\Admin\Repository;

use App\Models\Responsible as ResponsibleModel;
use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Shared\Domain\ValueObject\UUID;

class ResponsibleRepository implements ResponsibleGateway
{
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

    public function update(Responsible $responsible): void
    {
    }

    public function find(string $id): ?Responsible
    {
        $responsibleModel = ResponsibleModel::where('uuid', $id)->first();

        return $responsibleModel
            ? new Responsible(
                id: new UUID($responsibleModel->uuid),
                name: $responsibleModel->name,
                createdAt: new Carbon($responsibleModel->created_at),
                updatedAt: new Carbon($responsibleModel->updated_at),
            )
            : null;
    }

    /**
     * @return Responsible[]
     */
    public function list(): array
    {
        return [];
    }

    public function delete(string $id): void
    {
    }
}
