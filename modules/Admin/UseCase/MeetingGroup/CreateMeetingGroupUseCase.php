<?php

namespace Modules\Admin\UseCase\MeetingGroup;

use Modules\Admin\Domain\Entity\MeetingGroup;
use Modules\Admin\DTO\MeetingGroup\CreateMeetingGroupInputDTO;
use Modules\Admin\DTO\MeetingGroup\MeetingGroupOutputDTO;
use Modules\Admin\Gateway\MeetingGroupGateway;

class CreateMeetingGroupUseCase
{
    public function __construct(private MeetingGroupGateway $meetingGroupRepository)
    {
    }

    public function execute(CreateMeetingGroupInputDTO $input): MeetingGroupOutputDTO
    {
        $meeting = new MeetingGroup(name: $input->name, description: $input->description);

        $this->meetingGroupRepository->create($meeting);

        return new MeetingGroupOutputDTO(
            id: $meeting->getId()->value,
            name: $meeting->getName(),
            description: $meeting->getDescription(),
            createdAt: $meeting->getCreatedAt(),
            updatedAt: $meeting->getUpdatedAt(),
        );
    }
}
