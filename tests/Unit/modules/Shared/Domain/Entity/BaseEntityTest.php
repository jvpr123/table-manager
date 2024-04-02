<?php

namespace Tests\Unit\Modules\Shared\Domain\Entity;

use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\ValueObject\UUID;

describe('Base Entity unit tests', function () {
    beforeEach(function () {
        $this->BaseEntity = new class extends BaseEntity
        {
        };
    });

    it('should create a new entity generating id, createdAt and updatedAt attributes if not provided in constructor successfully', function () {
        $entity = new $this->BaseEntity();
        expect($entity)->toBeInstanceOf(BaseEntity::class);
    });

    it('should create a new entity generating id, createdAt and updatedAt attributes provided in constructor successfully', function () {
        $entity = new $this->BaseEntity(
            $uuid = new UUID(),
            $createdAt = now(),
            $updatedAt = now(),
        );

        expect($entity)->toBeInstanceOf(BaseEntity::class);
        expect($entity->getId()->value)->toBe($uuid->value);
        expect($entity->getCreatedAt())->toBe($createdAt);
        expect($entity->getUpdatedAt())->toBe($updatedAt);
    });

    it('should return entity id attribute successfully', function () {
        $entity = new $this->BaseEntity(id: $uuid = new UUID());
        expect($entity)->toBeInstanceOf(BaseEntity::class);
        expect($entity->getId())->toBeInstanceOf(UUID::class);
        expect($entity->getId()->value)->toBe($uuid->value);
    });

    it('should return entity createdAt attribute successfully', function () {
        $entity = new $this->BaseEntity(createdAt: $createdAt = now());
        expect($entity)->toBeInstanceOf(BaseEntity::class);
        expect($entity->getCreatedAt())->toBe($createdAt);
    });

    it('should return entity updatedAt attribute successfully', function () {
        $entity = new $this->BaseEntity(updatedAt: $updatedAt = now());
        expect($entity)->toBeInstanceOf(BaseEntity::class);
        expect($entity->getUpdatedAt())->toBe($updatedAt);
    });

    it('should update entity updatedAt attribute successfully', function () {
        $entity = new $this->BaseEntity();
        $updatedAt = now()->addDay();

        $entity->setUpdatedAt($updatedAt);
        expect($entity->getUpdatedAt())->toBe($updatedAt);
    });
});
