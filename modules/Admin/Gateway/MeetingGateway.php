<?php

namespace Modules\Admin\Gateway;

use Modules\Admin\Domain\Entity\Meeting;

interface MeetingGateway
{
    public function create(Meeting $meeting): void;

    /**
     * @param Meeting[] $meetings
     */
    public function createMany(array $meetings): void;

    public function update(Meeting $meeting): bool;

    public function find(string $id): ?Meeting;

    /**
     * @return Meeting[]
     */
    public function list(): array;

    public function delete(string $id): bool;
}
