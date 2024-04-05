<?php

namespace Modules\Admin\Gateway;

use Modules\Admin\Domain\Entity\Local;

interface LocalGateway
{
    public function create(Local $local): void;

    public function update(Local $local): bool;

    public function find(string $id): ?Local;

    /**
     * @return Local[]
     */
    public function list(): array;

    public function delete(string $id): bool;
}
