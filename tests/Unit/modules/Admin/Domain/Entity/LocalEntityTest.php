<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\Domain\Entity\Meeting;
use Modules\Shared\Domain\ValueObject\UUID;
use Modules\Shared\Exceptions\EntityAlreadyRelatedException;

describe('Local Entity unit tests', function () {
    beforeEach(function () {
        $this->local = new Local(
            title: $this->title = 'local_title',
            description: $this->description = 'local_description',
        );

        $this->meetingA = new Meeting(now());
        $this->meetingB = new Meeting(now()->addHour());
    });

    it('should generate a local entity successfully', function () {
        expect($this->local->getId())->toBeInstanceOf(UUID::class);
        expect($this->local->getCreatedAt()->toString())->toBe(now()->toString());
        expect($this->local->getUpdatedAt()->toString())->toBe(now()->toString());
    });

    it('should retrieve local title successfully', function () {
        expect($this->local->getTitle())->toBe($this->title);
    });

    it('should update local title successfully', function () {
        $this->local->setTitle($title = 'updated_title');
        expect($this->local->getTitle())->toBe($title);
    });

    it('should retrieve local description successfully', function () {
        expect($this->local->getDescription())->toBe($this->description);
    });

    it('should update local description successfully', function () {
        $this->local->setDescription($description = 'updated_description');
        expect($this->local->getDescription())->toBe($description);
    });

    it('should retrieve meetings ids related to local successfully', function () {
        expect($this->local->getMeetingsIds())->toHaveCount(0);
    });

    it('should relate/unrelate a meeting id to local successfully', function () {
        expect($this->local->getMeetingsIds())->toHaveCount(0);

        expect($this->local->addMeeting($this->meetingA))->toBeNull();
        expect($this->local->addMeeting($this->meetingB))->toBeNull();
        expect($this->local->getMeetingsIds())->toHaveCount(2);

        expect($this->local->removeMeeting($this->meetingB))->toBeNull();
        expect($this->local->getMeetingsIds())->toHaveCount(1);
    });

    it('should throw exception when trying to add an already related meeting to local', function () {
        $this->local->addMeeting($this->meetingA);
        expect($this->local->getMeetingsIds())->toHaveCount(1);

        expect(fn () => $this->local->addMeeting($this->meetingA))
            ->toThrow(new EntityAlreadyRelatedException($this->local, $this->meetingA));
        expect($this->local->getMeetingsIds())->toHaveCount(1);
    });
});
