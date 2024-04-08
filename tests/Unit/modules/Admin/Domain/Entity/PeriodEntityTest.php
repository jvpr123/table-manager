<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Period;
use Modules\Shared\Domain\ValueObject\UUID;

describe('Period Entity unit tests', function () {
    beforeEach(function () {
        $this->time = Carbon::createFromFormat('H:i', '08:30');
        $this->period = new Period($this->time);
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
        $time = Carbon::createFromFormat('H:i', '08:45');
        $this->period->setTime($time);
        expect($this->period->getTime())->toBe($time->format('H:i'));
    });
});
