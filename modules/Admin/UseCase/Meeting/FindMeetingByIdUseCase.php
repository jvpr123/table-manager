<?php

namespace Modules\Admin\UseCase\Meeting;

use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\DTO\Meeting\MeetingOutputDTO;
use Modules\Admin\Gateway\MeetingGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class FindMeetingByIdUseCase
{
    public function __construct(private MeetingGateway $meetingRepository)
    {
    }

    public function execute(string $id): MeetingOutputDTO
    {
        $meeting = $this->meetingRepository->find($id);

        if (!$meeting) {
            throw new EntityNotFoundException(Meeting::class, $id);
        }

        return new MeetingOutputDTO(
            id: $meeting->getId()->value,
            date: $meeting->getDate(),
            description: $meeting->getDescription(),
            createdAt: $meeting->getCreatedAt(),
            updatedAt: $meeting->getUpdatedAt(),
        );
    }
}
