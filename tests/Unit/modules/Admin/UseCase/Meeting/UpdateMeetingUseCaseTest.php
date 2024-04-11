<?php

namespace Tests\Unit\Modules\Admin\UseCase\Meeting;

use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\DTO\Meeting\MeetingOutputDTO;
use Modules\Admin\DTO\Meeting\UpdateMeetingInputDTO;
use Modules\Admin\Gateway\MeetingGateway;
use Modules\Admin\UseCase\Meeting\UpdateMeetingUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('UpdateMeetingUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockMeetingRepository = \Mockery::mock(MeetingGateway::class);
        $this->useCase = new UpdateMeetingUseCase($this->mockMeetingRepository);

        $this->meeting = new Meeting(
            date: now()->format('Y-m-d'),
            description: 'meeting_description',
        );

        $this->input = new UpdateMeetingInputDTO(
            id: $this->meeting->getId()->value,
            date: now()->addDay()->format('Y-m-d'),
            description: 'meeting_description',
        );
    });

    it('should update a meeting successfully', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->input->id)
            ->andReturn($this->meeting)
            ->once();

        $this->mockMeetingRepository
            ->expects()
            ->update(\Mockery::type(Meeting::class))
            ->once();

        $output = $this->useCase->execute($this->input);

        expect($output)->toBeInstanceOf(MeetingOutputDTO::class);
        expect($output->id)->toBe($this->input->id);
        expect($output->date)->toBe($this->input->date);
        expect($output->description)->toBe($this->input->description);
        expect($output->createdAt->toString())->toBe($this->meeting->getCreatedAt()->toString());
        expect($output->updatedAt->toString())->toBe(now()->toString());
    });

    it('should throw an exception if meeting not found', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->input->id)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new EntityNotFoundException(Meeting::class, $this->input->id));
    });

    it('should throw exception on getting meeting error', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->input->id)
            ->andThrow(new \Exception('Error getting meeting.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(\Exception::class, 'Error getting meeting.');
    });

    it('should throw exception on updating meeting error', function () {
        $this->mockMeetingRepository
            ->expects()
            ->find($this->input->id)
            ->andReturn($this->meeting)
            ->once();

        $this->mockMeetingRepository
            ->expects()
            ->update(\Mockery::type(Meeting::class))
            ->andThrow(new \Exception('Error updating meeting.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new \Exception('Error updating meeting.'));
    });
});
