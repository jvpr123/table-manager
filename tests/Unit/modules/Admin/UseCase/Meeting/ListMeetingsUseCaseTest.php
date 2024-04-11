<?php

namespace Tests\Unit\Modules\Admin\UseCase\Meeting;

use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\Gateway\MeetingGateway;
use Modules\Admin\UseCase\Meeting\ListMeetingsUseCase;

describe('ListMeetingsUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockMeetingRepository = \Mockery::mock(MeetingGateway::class);
        $this->useCase = new ListMeetingsUseCase($this->mockMeetingRepository);

        $this->meetings = [
            new Meeting(now()->format('Y-m-d')),
            new Meeting(now()->addDay()->format('Y-m-d')),
        ];
    });

    it('should return all meetings successfully', function () {
        $this->mockMeetingRepository
            ->expects()
            ->list()
            ->andReturn($this->meetings)
            ->once();

        $output = $this->useCase->execute();

        expect($output)->toHaveCount(count($this->meetings));
        foreach ($this->meetings as $key => $mee) {
            expect($mee->getId()->value)->toBe($this->meetings[$key]->getId()->value);
            expect($mee->getDate())->toBe($this->meetings[$key]->getDate());
        };
    });

    it('should return empty array if no responsible found', function () {
        $this->mockMeetingRepository
            ->expects()
            ->list()
            ->andReturn([])
            ->once();

        $output = $this->useCase->execute();

        expect($output)->toBeEmpty();
    });

    it('should throw exception on repository error', function () {
        $this->mockMeetingRepository
            ->expects()
            ->list()
            ->andThrow(new \Exception('Error getting meetings.'))
            ->once();

        expect(fn () => $this->useCase->execute())
            ->toThrow(new \Exception('Error getting meetings.'));
    });
});
