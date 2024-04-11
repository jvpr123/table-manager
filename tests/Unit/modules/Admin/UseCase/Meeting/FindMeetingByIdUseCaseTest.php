<?php

namespace Tests\Unit\Modules\Admin\UseCase\Meeting;

use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\DTO\Meeting\MeetingOutputDTO;
use Modules\Admin\Gateway\MeetingGateway;
use Modules\Admin\UseCase\Meeting\FindMeetingByIdUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('FindMeetingByIdUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockMeetingRepository = \Mockery::mock(MeetingGateway::class);
        $this->useCase = new FindMeetingByIdUseCase($this->mockMeetingRepository);

        $this->meeting = new Meeting(date: now()->format('Y-m-d'));
        $this->meetingId = $this->meeting->getId()->value;
    });

    it('should return a meeting successfully', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->meetingId)
            ->andReturn($this->meeting)
            ->once();

        $output = $this->useCase->execute($this->meetingId);

        expect($output)->toBeInstanceOf(MeetingOutputDTO::class);
        expect($output->id)->toBe($this->meeting->getId()->value);
    });

    it('should throw exception if meeting not found', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->meetingId)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->meetingId))
            ->toThrow(new EntityNotFoundException(Meeting::class, $this->meetingId));
    });

    it('should throw exception on repository error', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->meetingId)
            ->andThrow(new \Exception('Error getting meeting.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->meetingId))
            ->toThrow(new \Exception('Error getting meeting.'));
    });
});
