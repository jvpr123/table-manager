<?php

namespace Modules\Admin\UseCase\Meeting;

use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\DTO\Meeting\CreateMeetingInputDTO;
use Modules\Admin\Gateway\MeetingGateway;

class CreateManyMeetingsUseCase
{
    public function __construct(private MeetingGateway $meetingRepository)
    {
    }

    /**
     * @param CreateMeetingInputDTO[] $input
     */
    public function execute(array $input): void
    {
        $meetings = array_map(fn (CreateMeetingInputDTO $dto) => new Meeting(
            date: $dto->date,
            description: $dto->description,
        ), $input);

        $this->meetingRepository->createMany($meetings);
    }
}
