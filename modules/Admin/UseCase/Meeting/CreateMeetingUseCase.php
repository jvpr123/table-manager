<?php

namespace Modules\Admin\UseCase\Meeting;

use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\DTO\Meeting\CreateMeetingInputDTO;
use Modules\Admin\DTO\Meeting\MeetingOutputDTO;
use Modules\Admin\Gateway\MeetingGateway;

class CreateMeetingUseCase
{
    public function __construct(private MeetingGateway $meetingRepository)
    {
    }

    public function execute(CreateMeetingInputDTO $input): MeetingOutputDTO
    {
        $meeting = new Meeting(date: $input->date, description: $input->description);

        $this->meetingRepository->create($meeting);

        return new MeetingOutputDTO(
            id: $meeting->getId()->value,
            date: $meeting->getDate(),
            description: $meeting->getDescription(),
            createdAt: $meeting->getCreatedAt(),
            updatedAt: $meeting->getUpdatedAt(),
        );
    }
}
