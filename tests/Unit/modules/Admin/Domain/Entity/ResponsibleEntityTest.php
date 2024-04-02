<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use Modules\Admin\Domain\Entity\Responsible;
use Modules\Shared\Domain\ValueObject\UUID;

describe('Responsible Entity unit tests', function () {
    beforeEach(function () {
        $this->responsible = new Responsible($this->name = 'responsible_name');
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
});
