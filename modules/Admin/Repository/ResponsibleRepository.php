<?php

namespace Modules\Admin\Repository;

use App\Models\Responsible as ResponsibleModel;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\Gateway\ResponsibleGateway;

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
        return null;
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
