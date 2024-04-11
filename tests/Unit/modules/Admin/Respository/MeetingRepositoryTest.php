<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\Meeting as MeetingModel;
use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\Repository\MeetingRepository;

describe('MeetingRepository create() unit tests', function () {
    beforeEach(function () {
        $this->meeting = new Meeting(
            date: now()->format('Y-m-d'),
            description: 'meeting_description',
        );

        $this->repository = new MeetingRepository();
    });

    it('should register a meeting in database successfully', function () {
        $output = $this->repository->create($this->meeting);

        expect($output)->toBeNull();
        $this->assertDatabaseHas('meetings', [
            'uuid' => $this->meeting->getId()->value,
            'date' => $this->meeting->getDate(),
            'description' => $this->meeting->getDescription(),
            'created_at' => $this->meeting->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->meeting->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);
    });

    it('should throw exception on meeting saving error', function () {
        expect(function () {
            MeetingModel::saving(throw new \Exception('Error saving meeting.'));
            $this->repository->create($this->meeting);
        })->toThrow(new \Exception('Error saving meeting.'));

        $this->assertDatabaseMissing('meetings', ['uuid' => $this->meeting->getId()->value]);
    });
});
