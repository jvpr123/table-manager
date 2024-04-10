<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use Modules\Admin\Domain\Entity\Local;
use Modules\Shared\Domain\ValueObject\UUID;

describe('Local Entity unit tests', function () {
    beforeEach(fn () => $this->local = new Local(
        title: $this->title = 'local_title',
        description: $this->description = 'local_description',
    ));

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
});
