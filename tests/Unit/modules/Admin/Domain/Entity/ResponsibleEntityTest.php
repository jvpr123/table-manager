<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Shared\Domain\ValueObject\UUID;
use Modules\Shared\Exceptions\EntityAlreadyRelatedException;

describe('Responsible Entity unit tests', function () {
    beforeEach(function () {
        $this->responsible = new Responsible($this->name = 'responsible_name');

        $this->meetingA = new Meeting(now());
        $this->meetingB = new Meeting(now()->addHour());
    });

    it('should generate a responsible entity successfully', function () {
        expect($this->responsible->getId())->toBeInstanceOf(UUID::class);
        expect($this->responsible->getCreatedAt()->toString())->toBe(now()->toString());
        expect($this->responsible->getUpdatedAt()->toString())->toBe(now()->toString());
    });

    it('should retrieve responsible name successfully', function () {
        expect($this->responsible->getName())->toBe($this->name);
    });

    it('should update responsible name successfully', function () {
        $this->responsible->setName($name = 'updated_name');
        expect($this->responsible->getName())->toBe($name);
    });

    it('should retrieve meetings ids related to responsible successfully', function () {
        expect($this->responsible->getMeetingsIds())->toHaveCount(0);
    });

    it('should relate/unrelate a meeting id to responsible successfully', function () {
        expect($this->responsible->getMeetingsIds())->toHaveCount(0);

        expect($this->responsible->addMeeting($this->meetingA))->toBeNull();
        expect($this->responsible->addMeeting($this->meetingB))->toBeNull();
        expect($this->responsible->getMeetingsIds())->toHaveCount(2);

        expect($this->responsible->removeMeeting($this->meetingB))->toBeNull();
        expect($this->responsible->getMeetingsIds())->toHaveCount(1);
    });

    it('should throw exception when trying to add an already related meeting to responsible', function () {
        $this->responsible->addMeeting($this->meetingA);
        expect($this->responsible->getMeetingsIds())->toHaveCount(1);

        expect(fn () => $this->responsible->addMeeting($this->meetingA))
            ->toThrow(new EntityAlreadyRelatedException($this->responsible, $this->meetingA));
        expect($this->responsible->getMeetingsIds())->toHaveCount(1);
    });
});
