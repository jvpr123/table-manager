<?php

namespace Tests\Unit\Modules\Admin\UseCase\Meeting;

use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\DTO\Meeting\CreateMeetingInputDTO;
use Modules\Admin\DTO\Meeting\MeetingOutputDTO;
use Modules\Admin\Gateway\MeetingGateway;
use Modules\Admin\UseCase\Meeting\CreateMeetingUseCase;

describe('CreateMeetingUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockMeetingRepository = \Mockery::mock(MeetingGateway::class);
        $this->useCase = new CreateMeetingUseCase($this->mockMeetingRepository);

        $this->input = new CreateMeetingInputDTO(
            date: Carbon::createFromFormat('H:i', '8:30')->format('Y-m-d'),
            description: 'meeting_description',
        );
    });

    it('should create a meeting successfully', function () {
        $this->mockMeetingRepository
            ->expects()
            ->create(\Mockery::type(Meeting::class))
            ->once();

        $output = $this->useCase->execute($this->input);

        expect($output)->toBeInstanceOf(MeetingOutputDTO::class);
        expect($output->id)->toBeString();
        expect($output->date)->toBe($this->input->date);
        expect($output->createdAt->toString())->toBe(now()->toString());
        expect($output->updatedAt->toString())->toBe(now()->toString());
    });

    it('should throw exception on creating meeting error', function () {
        $this->mockMeetingRepository
            ->expects()
            ->create(\Mockery::type(Meeting::class))
            ->andThrow(new \Exception('Error creating meeting.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new \Exception('Error creating meeting.'));
    });
});
