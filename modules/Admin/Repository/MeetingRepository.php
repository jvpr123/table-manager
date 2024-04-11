<?php

namespace Modules\Admin\Repository;

use App\Models\Meeting as MeetingModel;
use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\Gateway\MeetingGateway;
use Modules\Shared\Domain\ValueObject\UUID;

class MeetingRepository implements MeetingGateway
{
    public function create(Meeting $meeting): void
    {
        $meetingModel = new MeetingModel([
            'uuid' => $meeting->getId()->value,
            'date' => $meeting->getDate(),
            'description' => $meeting->getDescription(),
            'created_at' => $meeting->getCreatedAt(),
            'updated_at' => $meeting->getUpdatedAt(),
        ]);

        $meetingModel->saveOrFail();
    }

    /**
     * @param Meeting[] $meetings
     */
    public function createMany(array $meetings): void
    {
    }

    public function update(Meeting $meeting): bool
    {
        return false;
    }

    public function find(string $id): ?Meeting
    {
        return null;
    }

    /**
     * @return Meeting[]
     */
    public function list(): array
    {
        return [];
    }

    public function delete(string $id): bool
    {
        return false;
    }
}
