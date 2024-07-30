<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use App\Models\Responsible as ResponsibleModel;
use App\Models\Period as PeriodModel;
use App\Models\Local as LocalModel;
use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\Domain\Entity\MeetingGroup;
use Modules\Admin\Domain\Entity\Period;
use Modules\Shared\Domain\ValueObject\UUID;
use Modules\Shared\Exceptions\InvalidEntityProvidedException;

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

    // Responsibles getter/setter
    it('should define Meeting Group related Responsibles successfully', function () {
        $responsibles = ResponsibleModel::factory()
            ->count(2)
            ->create()
            ->map(fn (ResponsibleModel $res) => new Responsible(
                id: new UUID($res->uuid),
                name: $res->name,
                createdAt: $res->created_at,
                updatedAt: $res->updated_at,
            ))
            ->toArray();

        $output = $this->meetingGroup->setResponsibles($responsibles);
        expect($output)->toBe($responsibles);
    });

    it('should throw exception if invalid entity is provided to responsibles setter', function () {
        $responsibles = ResponsibleModel::factory()
            ->count(2)
            ->create()
            ->map(fn (ResponsibleModel $res) => new Responsible(
                id: new UUID($res->uuid),
                name: $res->name,
                createdAt: $res->created_at,
                updatedAt: $res->updated_at,
            ))
            ->toArray();

        $responsibles[] = new Local(title: 'local_title');

        $this->meetingGroup->setResponsibles($responsibles);
    })->throws(InvalidEntityProvidedException::class);

    it('should return an empty array if Meeting Group has no related Responsibles successfully', function () {
        expect($this->meetingGroup->getResponsibles())->toBeEmpty();
    });

    it('should return Meeting Group related Responsibles successfully', function () {
        $responsibles = ResponsibleModel::factory()
            ->count(2)
            ->create()
            ->map(fn (ResponsibleModel $res) => new Responsible(
                id: new UUID($res->uuid),
                name: $res->name,
                createdAt: $res->created_at,
                updatedAt: $res->updated_at,
            ))
            ->toArray();

        $this->meetingGroup->setResponsibles($responsibles);

        $output = $this->meetingGroup->getResponsibles();
        expect($output)->toBe($responsibles);
    });

    // Periods getter/setter
    it('should define Meeting Group related Periods successfully', function () {
        $periods = PeriodModel::factory()
            ->count(2)
            ->create()
            ->map(fn (PeriodModel $per) => new Period(
                id: new UUID($per->uuid),
                time: $per->time,
                createdAt: $per->created_at,
                updatedAt: $per->updated_at,
            ))
            ->toArray();

        $output = $this->meetingGroup->setPeriods($periods);
        expect($output)->toBe($periods);
    });

    it('should throw exception if invalid entity is provided to periods setter', function () {
        $periods = PeriodModel::factory()
            ->count(2)
            ->create()
            ->map(fn (PeriodModel $per) => new Period(
                id: new UUID($per->uuid),
                time: $per->time,
                createdAt: $per->created_at,
                updatedAt: $per->updated_at,
            ))
            ->toArray();

        $periods[] = new Local(title: 'local_title');

        $this->meetingGroup->setPeriods($periods);
    })->throws(InvalidEntityProvidedException::class);

    it('should return an empty array if Meeting Group has no related Periods successfully', function () {
        expect($this->meetingGroup->getPeriods())->toBeEmpty();
    });

    it('should return Meeting Group related Periods successfully', function () {
        $periods = PeriodModel::factory()
            ->count(2)
            ->create()
            ->map(fn (PeriodModel $per) => new Period(
                id: new UUID($per->uuid),
                time: $per->time,
                createdAt: $per->created_at,
                updatedAt: $per->updated_at,
            ))
            ->toArray();

        $this->meetingGroup->setPeriods($periods);

        $output = $this->meetingGroup->getPeriods();
        expect($output)->toBe($periods);
    });

    // Locals getter/setter
    it('should define Meeting Group related Locals successfully', function () {
        $locals = LocalModel::factory()
            ->count(2)
            ->create()
            ->map(fn (LocalModel $loc) => new Local(
                id: new UUID($loc->uuid),
                title: $loc->title,
                createdAt: $loc->created_at,
                updatedAt: $loc->updated_at,
            ))
            ->toArray();

        $output = $this->meetingGroup->setLocals($locals);
        expect($output)->toBe($locals);
    });

    it('should throw exception if invalid entity is provided to locals setter', function () {
        $locals = LocalModel::factory()
            ->count(2)
            ->create()
            ->map(fn (LocalModel $loc) => new Local(
                id: new UUID($loc->uuid),
                title: $loc->title,
                createdAt: $loc->created_at,
                updatedAt: $loc->updated_at,
            ))
            ->toArray();

        $locals[] = new Responsible(name: 'responsible_name');

        $this->meetingGroup->setLocals($locals);
    })->throws(InvalidEntityProvidedException::class);

    it('should return an empty array if Meeting Group has no related Locals successfully', function () {
        expect($this->meetingGroup->getLocals())->toBeEmpty();
    });

    it('should return Meeting Group related Locals successfully', function () {
        $locals = LocalModel::factory()
            ->count(2)
            ->create()
            ->map(fn (LocalModel $loc) => new Local(
                id: new UUID($loc->uuid),
                title: $loc->title,
                createdAt: $loc->created_at,
                updatedAt: $loc->updated_at,
            ))
            ->toArray();

        $this->meetingGroup->setLocals($locals);

        $output = $this->meetingGroup->getLocals();
        expect($output)->toBe($locals);
    });
});
