<?php

namespace Modules\Admin\UseCase\Meeting;

use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\DTO\Meeting\MeetingOutputDTO;
use Modules\Admin\Gateway\MeetingGateway;

class ListMeetingsUseCase
{
    public function __construct(private MeetingGateway $meetingRepository)
    {
    }

    /**
     * @return MeetingOutputDTO[]
     */
    public function execute(): array
    {
        $meetings = $this->meetingRepository->list();

        return array_map(fn (Meeting $meeting) => new MeetingOutputDTO(
            id: $meeting->getId()->value,
            date: $meeting->getDate(),
            description: $meeting->getDescription(),
            createdAt: $meeting->getCreatedAt(),
            updatedAt: $meeting->getUpdatedAt(),
        ), $meetings);
    }
}
