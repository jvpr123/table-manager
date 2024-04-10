<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\Domain\Entity\Meeting;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Shared\Domain\ValueObject\UUID;

describe('Meeting Entity unit tests', function () {
    beforeEach(function () {
        $this->meeting = new Meeting(
            date: $this->date = now(),
            description: $this->description = 'meeting_description'
        );

        $this->responsible = new Responsible(name: 'responsible_name');
        $this->period = new Period(time: now());
        $this->local = new Local(title: 'local_title', description: 'local_description');
    });

    it('should generate a Meeting entity with description successfully', function () {
        expect($this->meeting->getId())->toBeInstanceOf(UUID::class);
        expect($this->meeting->getCreatedAt()->toString())->toBe(now()->toString());
        expect($this->meeting->getUpdatedAt()->toString())->toBe(now()->toString());
    });

    it('should generate a Meeting entity without description successfully', function () {
        $meeting = new Meeting(date: $this->date);
        expect($meeting->getId())->toBeInstanceOf(UUID::class);
        expect($meeting->getCreatedAt()->toString())->toBe(now()->toString());
        expect($meeting->getUpdatedAt()->toString())->toBe(now()->toString());
    });

    it('should retrieve meeting date successfully', function () {
        expect($this->meeting->getDate())->toBe($this->date->format('H:i'));
    });

    it('should update meeting date successfully', function () {
        $this->meeting->setDate($date = now()->addHour());
        expect($this->meeting->getDate())->toBe($date->format('H:i'));
    });

    it('should retrieve meeting description successfully', function () {
        expect($this->meeting->getDescription())->toBe($this->description);
    });

    it('should update meeting description successfully', function () {
        $this->meeting->setDescription($description = 'updated_description');
        expect($this->meeting->getDescription())->toBe($description);
    });

    it('should set/unset meeting responsible successfully', function () {
        $output = $this->meeting->setResponsible($this->responsible);
        expect($this->meeting->getResponsibleId())->toBe($this->responsible->getId()->value);
        expect($this->meeting->getResponsible())->toBe($this->responsible);

        $output = $this->meeting->unsetResponsible();
        expect($output)->toBeNull();
        expect($this->meeting->getResponsibleId())->toBeNull();
        expect($this->meeting->getResponsible())->toBeNull();
    });

    it('should set/unset meeting period successfully', function () {
        $output = $this->meeting->setPeriod($this->period);
        expect($this->meeting->getPeriodId())->toBe($this->period->getId()->value);
        expect($this->meeting->getPeriod())->toBe($this->period);

        $output = $this->meeting->unsetPeriod();
        expect($output)->toBeNull();
        expect($this->meeting->getPeriodId())->toBeNull();
        expect($this->meeting->getPeriod())->toBeNull();
    });

    it('should set/unset meeting local successfully', function () {
        $output = $this->meeting->setLocal($this->local);
        expect($this->meeting->getLocalId())->toBe($this->local->getId()->value);
        expect($this->meeting->getLocal())->toBe($this->local);

        $output = $this->meeting->unsetLocal();
        expect($output)->toBeNull();
        expect($this->meeting->getLocalId())->toBeNull();
        expect($this->meeting->getLocal())->toBeNull();
    });
});
