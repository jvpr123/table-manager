<?php

namespace Tests\Unit\Modules\Admin\UseCase\Meeting;

use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\Gateway\MeetingGateway;
use Modules\Admin\UseCase\Meeting\DeleteMeetingUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('DeleteMeetingUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockMeetingRepository = \Mockery::mock(MeetingGateway::class);
        $this->useCase = new DeleteMeetingUseCase($this->mockMeetingRepository);

        $this->meeting = new Meeting(date: now()->format('Y-m-d'));
        $this->meetingId = $this->meeting->getId()->value;
    });

    it('should delete a meeting successfully', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->meetingId)
            ->andReturn($this->meeting)
            ->once();

        $this->mockMeetingRepository
            ->expects()
            ->delete($this->meetingId)
            ->once();

        expect($this->useCase->execute($this->meetingId))->toBeNull();
    });

    it('should throw an exception if meeting not found', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->meetingId)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->meetingId))
            ->toThrow(new EntityNotFoundException(Meeting::class, $this->meetingId));
    });

    it('should throw exception on getting meeting error', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->meetingId)
            ->andThrow(new \Exception('Error getting meeting.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->meetingId))
            ->toThrow(\Exception::class, 'Error getting meeting.');
    });

    it('should throw exception on deleting meeting error', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->meetingId)
            ->andReturn($this->meeting)
            ->once();

        $this->mockMeetingRepository
            ->expects()
            ->delete($this->meetingId)
            ->andThrow(new \Exception('Error deleting meeting.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->meetingId))
            ->toThrow(new \Exception('Error deleting meeting.'));
    });
});
