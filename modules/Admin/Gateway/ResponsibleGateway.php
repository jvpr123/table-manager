<?php

namespace Modules\Admin\Gateway;

use Modules\Admin\Domain\Entity\Responsible;

interface ResponsibleGateway
{
    public function create(Responsible $responsible): void;

    public function update(Responsible $responsible): void;

    public function find(string $id): ?Responsible;

    /**
     * @return Responsible[]
     */
    public function list(): array;

    public function delete(string $id): void;
}
