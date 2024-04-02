<?php

namespace Modules\Admin\Gateway;

use Modules\Admin\Domain\Entity\ResponsibleEntity;

interface ResponsibleGateway
{
    public function create(ResponsibleEntity $responsible): void;

    public function update(ResponsibleEntity $responsible): void;

    public function find(string $id): ?ResponsibleEntity;

    /**
     * @return ResponsibleEntity[]
     */
    public function list(): array;

    public function delete(string $id): void;
}
