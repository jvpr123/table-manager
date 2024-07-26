<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use Modules\Admin\Domain\Entity\MeetingDay;
use Modules\Shared\Domain\ValueObject\UUID;

describe('MeetingDay Entity unit tests', function () {
    beforeEach(function () {
        $this->meetingDay = new MeetingDay(
            name: $this->name = 'meeting_day_name',
            description: $this->description = 'meeting_day_description'
        );
    });

    it('should generate a MeetingDay entity with description successfully', function () {
        expect($this->meetingDay->getId())->toBeInstanceOf(UUID::class);
        expect($this->meetingDay->getCreatedAt()->toString())->toBe(now()->toString());
        expect($this->meetingDay->getUpdatedAt()->toString())->toBe(now()->toString());
    });

    it('should generate a MeetingDay entity without description successfully', function () {
        $meetingDay = new MeetingDay(name: $this->name);
        expect($meetingDay->getId())->toBeInstanceOf(UUID::class);
        expect($meetingDay->getCreatedAt()->toString())->toBe(now()->toString());
        expect($meetingDay->getUpdatedAt()->toString())->toBe(now()->toString());
    });

    it('should retrieve MeetingDay name successfully', function () {
        expect($this->meetingDay->getName())->toBe($this->name);
    });

    it('should update Meeting Day name successfully', function () {
        $this->meetingDay->setName($name = 'updated_name');
        expect($this->meetingDay->getName())->toBe($name);
    });

    it('should retrieve Meeting Day description successfully', function () {
        expect($this->meetingDay->getDescription())->toBe($this->description);
    });

    it('should update Meeting Day description successfully', function () {
        $this->meetingDay->setDescription($description = 'updated_description');
        expect($this->meetingDay->getDescription())->toBe($description);
    });
});
