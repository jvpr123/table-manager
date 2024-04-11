<?php

namespace Modules\Admin\UseCase\Meeting;

use Modules\Admin\DTO\Meeting\MeetingOutputDTO;
use Modules\Admin\DTO\Meeting\UpdateMeetingInputDTO;
use Modules\Admin\Gateway\MeetingGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class UpdateMeetingUseCase
{
    public function __construct(private MeetingGateway $meetingRepository)
    {
    }

    public function execute(UpdateMeetingInputDTO $input): MeetingOutputDTO
    {
        $meeting = $this->meetingRepository->find($input->id);

        if (!$meeting) {
            throw new EntityNotFoundException('Meeting', $input->id);
        }

        if ($input->date) {
            $meeting->setDate($input->date);
        }

        $meeting->setDescription($input->description);
        $meeting->setUpdatedAt(now());

        $this->meetingRepository->update($meeting);

        return new MeetingOutputDTO(
            id: $meeting->getId()->value,
            date: $meeting->getDate(),
            description: $meeting->getDescription(),
            createdAt: $meeting->getCreatedAt(),
            updatedAt: $meeting->getUpdatedAt(),
        );
    }
}
