<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\Domain\Entity\Period;
use Modules\Shared\Domain\ValueObject\UUID;
use Modules\Shared\Exceptions\EntityAlreadyRelatedException;

describe('Period Entity unit tests', function () {
    beforeEach(function () {
        $this->time = Carbon::createFromFormat('H:i', '08:30');
        $this->period = new Period($this->time->format('H:i'));

        $this->meetingA = new Meeting(now());
        $this->meetingB = new Meeting(now()->addHour());
    });

    it('should generate a period entity successfully', function () {
        expect($this->period->getId())->toBeInstanceOf(UUID::class);
        expect($this->period->getCreatedAt()->toString())->toBe(now()->toString());
        expect($this->period->getUpdatedAt()->toString())->toBe(now()->toString());
    });

    it('should retrieve period time successfully', function () {
        expect($this->period->getTime())->toBe($this->time->format('H:i'));
    });

    it('should update period time successfully', function () {
        $time = Carbon::createFromFormat('H:i', '08:45')->format('H:i');
        $this->period->setTime($time);
        expect($this->period->getTime())->toBe($time);
    });

    it('should retrieve meetings ids related to period successfully', function () {
        expect($this->period->getMeetingsIds())->toHaveCount(0);
    });

    it('should relate/unrelate a meeting id to period successfully', function () {
        expect($this->period->getMeetingsIds())->toHaveCount(0);

        expect($this->period->addMeeting($this->meetingA))->toBeNull();
        expect($this->period->addMeeting($this->meetingB))->toBeNull();
        expect($this->period->getMeetingsIds())->toHaveCount(2);

        expect($this->period->removeMeeting($this->meetingB))->toBeNull();
        expect($this->period->getMeetingsIds())->toHaveCount(1);
    });

    it('should throw exception when trying to add an already related meeting to period', function () {
        $this->period->addMeeting($this->meetingA);
        expect($this->period->getMeetingsIds())->toHaveCount(1);

        expect(fn () => $this->period->addMeeting($this->meetingA))
            ->toThrow(new EntityAlreadyRelatedException($this->period, $this->meetingA));
        expect($this->period->getMeetingsIds())->toHaveCount(1);
    });
});
