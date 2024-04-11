<?php

namespace Tests\Unit\Modules\Admin\UseCase\Meeting;

use Modules\Admin\DTO\Meeting\CreateMeetingInputDTO;
use Modules\Admin\Gateway\MeetingGateway;
use Modules\Admin\UseCase\Meeting\CreateManyMeetingsUseCase;

describe('CreateManyMeetingsUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockMeetingRepository = \Mockery::mock(MeetingGateway::class);
        $this->useCase = new CreateManyMeetingsUseCase($this->mockMeetingRepository);

        $this->meetingA = new CreateMeetingInputDTO(date: now()->format('Y-m-d'));
        $this->meetingB = new CreateMeetingInputDTO(date: now()->addDay()->format('Y-m-d'));
        $this->input = [$this->meetingA, $this->meetingB];
    });

    it('should create many meetings successfully', function () {
        $this->mockMeetingRepository
            ->expects()
            ->createMany(\Mockery::type('array'))
            ->once();

        expect($this->useCase->execute($this->input))->toBeNull();
    });

    it('should throw exception on creating meeting error', function () {
        $this->mockMeetingRepository
            ->expects()
            ->createMany(\Mockery::type('array'))
            ->andThrow(new \Exception('Error creating meetings.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new \Exception('Error creating meetings.'));
    });
});
