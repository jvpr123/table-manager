<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\MeetingDay as MeetingDayModel;
use Modules\Admin\Domain\Entity\MeetingDay;
use Modules\Admin\Repository\MeetingDayRepository;

describe('MeetingDayRepository create() unit tests', function () {
    beforeEach(function () {
        $this->meetingDay = new MeetingDay(
            name: 'meeting_day_name',
            description: 'meeting_day_description',
        );

        $this->repository = new MeetingDayRepository();
    });

    it('should register a Meeting Day in database successfully', function () {
        $output = $this->repository->create($this->meetingDay);

        expect($output)->toBeNull();
        $this->assertDatabaseHas('meeting_days', [
            'uuid' => $this->meetingDay->getId()->value,
            'name' => $this->meetingDay->getName(),
            'description' => $this->meetingDay->getDescription(),
            'created_at' => $this->meetingDay->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->meetingDay->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);
    });

    it('should throw exception on MeetingDay saving error', function () {
        expect(function () {
            MeetingDayModel::saving(throw new \Exception('Error saving meeting day.'));
            $this->repository->create($this->meetingDay);
        })->toThrow(new \Exception('Error saving meeting day.'));

        $this->assertDatabaseMissing('meeting_days', ['uuid' => $this->meetingDay->getId()->value]);
    });
});
