<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use Modules\Admin\Domain\Entity\MeetingGroup;
use Modules\Shared\Domain\ValueObject\UUID;

describe('MeetingGroup Entity unit tests', function () {
    beforeEach(function () {
        $this->meetingGroup = new MeetingGroup(
            name: $this->name = 'meeting_group_name',
            description: $this->description = 'meeting_group_description'
        );
    });

    it('should generate a MeetingGroup entity with description successfully', function () {
        expect($this->meetingGroup->getId())->toBeInstanceOf(UUID::class);
        expect($this->meetingGroup->getCreatedAt()->toString())->toBe(now()->toString());
        expect($this->meetingGroup->getUpdatedAt()->toString())->toBe(now()->toString());
    });

    it('should generate a MeetingGroup entity without description successfully', function () {
        $meetingGroup = new MeetingGroup(name: $this->name);
        expect($meetingGroup->getId())->toBeInstanceOf(UUID::class);
        expect($meetingGroup->getCreatedAt()->toString())->toBe(now()->toString());
        expect($meetingGroup->getUpdatedAt()->toString())->toBe(now()->toString());
    });

    it('should retrieve MeetingGroup name successfully', function () {
        expect($this->meetingGroup->getName())->toBe($this->name);
    });

    it('should update Meeting Group name successfully', function () {
        $this->meetingGroup->setName($name = 'updated_name');
        expect($this->meetingGroup->getName())->toBe($name);
    });

    it('should retrieve Meeting Group description successfully', function () {
        expect($this->meetingGroup->getDescription())->toBe($this->description);
    });

    it('should update Meeting Group description successfully', function () {
        $this->meetingGroup->setDescription($description = 'updated_description');
        expect($this->meetingGroup->getDescription())->toBe($description);
    });
});
