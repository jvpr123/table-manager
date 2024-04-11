<?php

namespace Modules\Admin\UseCase\Meeting;

use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\Gateway\MeetingGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class DeleteMeetingUseCase
{
    public function __construct(private MeetingGateway $meetingRepository)
    {
    }

    public function execute(string $id): void
    {
        $meeting = $this->meetingRepository->find($id);

        if (!$meeting) {
            throw new EntityNotFoundException(Meeting::class, $id);
        }

        $this->meetingRepository->delete($id);
    }
}
