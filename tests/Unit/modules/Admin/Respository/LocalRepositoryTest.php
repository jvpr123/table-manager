<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\Local as LocalModel;
use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\Repository\LocalRepository;

describe('LocalRepository create() unit tests', function () {
    beforeEach(function () {
        $this->local = new Local(
            title: 'local_title',
            description: 'local_description',
        );

        $this->repository = new LocalRepository();
    });

    it('should register a local in database successfully', function () {
        $output = $this->repository->create($this->local);

        expect($output)->toBeNull();
        $this->assertDatabaseHas('locals', [
            'uuid' => $this->local->getId()->value,
            'title' => $this->local->getTitle(),
            'description' => $this->local->getDescription(),
            'created_at' => $this->local->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->local->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);
    });

    it('should throw exception on local saving error', function () {
        expect(function () {
            LocalModel::saving(throw new \Exception('Error saving local.'));
            $this->repository->create($this->local);
        })->toThrow(new \Exception('Error saving local.'));

        $this->assertDatabaseMissing('locals', ['uuid' => $this->local->getId()->value]);
    });
});

describe('LocalRepository update() unit tests', function () {
    beforeEach(function () {
        $this->localEntity = new Local(
            title: 'local_title',
            description: 'local_description',
        );

        $this->repository = new LocalRepository();
    });

    it('should return true if local update succeeded', function () {
        $this->localModel = LocalModel::factory()->create([
            'uuid' => $this->localEntity->getId()->value,
            'title' => $this->localEntity->getTitle(),
            'description' => $this->localEntity->getDescription(),
            'created_at' => $this->localEntity->getCreatedAt(),
            'updated_at' => $this->localEntity->getUpdatedAt(),
        ]);

        $this->localEntity->setTitle($title = 'updated_title');
        $this->localEntity->setDescription($description = 'updated_description');
        $this->localEntity->setUpdatedAt($date = now()->addDay());

        $output = $this->repository->update($this->localEntity);

        expect($output)->toBeTrue();
        $this->assertDatabaseHas('locals', [
            'uuid' => $this->localModel->uuid,
            'title' => $title,
            'description' => $description,
            'updated_at' => $date->format('Y-m-d H:i:s'),
            'created_at' => $this->localModel->created_at,
        ]);
    });

    it('should return false if local deletion failed', function () {
        $output = $this->repository->update($this->localEntity);
        expect($output)->toBeFalse();
    });

    it('should throw exception on local update error', function () {
        expect(function () {
            LocalModel::updating(throw new \Exception('Error updating local.'));
            $this->repository->update($this->localEntity);
        })->toThrow(new \Exception('Error updating local.'));
    });
});

describe('LocalRepository find() unit tests', function () {
    beforeEach(function () {
        $this->localEntity = new Local(title: $this->title = 'local_title');
        $this->localId = $this->localEntity->getId()->value;
        $this->localModel = LocalModel::factory()->create([
            'uuid' => $this->localEntity->getId()->value,
            'title' => $this->localEntity->getTitle(),
            'description' => $this->localEntity->getDescription(),
            'created_at' => $this->localEntity->getCreatedAt(),
            'updated_at' => $this->localEntity->getUpdatedAt(),
        ]);

        $this->repository = new LocalRepository();
    });

    it('should retrieve a local from database successfully', function () {
        $output = $this->repository->find($this->localId);
        expect($output)->toBeInstanceOf(Local::class);
        expect($output->getId()->value)->toBe($this->localId);
    });

    it('should return null if local not found', function () {
        expect($this->repository->find(id: ''))->toBeNull();
    });
});

describe('LocalRepository list() unit tests', function () {
    beforeEach(fn () => $this->repository = new LocalRepository());

    it('should retrieve all locals from database successfully', function () {
        $localEntities = [
            new Local(title: 'local_title_a'),
            new Local(title: 'local_title_b'),
        ];

        foreach ($localEntities as $pe) {
            LocalModel::factory()->create([
                'uuid' => $pe->getId()->value,
                'title' => $pe->getTitle(),
                'description' => $pe->getDescription(),
                'created_at' => $pe->getCreatedAt(),
                'updated_at' => $pe->getUpdatedAt(),
            ]);
        }

        $output = $this->repository->list();
        expect($output)->toHaveCount(count($localEntities));
    });

    it('should return empty array if no local found', function () {
        expect($this->repository->list())->toBeEmpty();
    });
});

describe('LocalRepository delete() unit tests', function () {
    beforeEach(function () {
        $this->localModel = LocalModel::factory()->create(['uuid' => uuid_create()]);
        $this->repository = new LocalRepository();
    });

    it('should return true if local deletion succeeded', function () {
        $this->assertDatabaseHas('locals', ['uuid' => $this->localModel->uuid]);

        $output = $this->repository->delete($this->localModel->uuid);

        expect($output)->toBeTrue();
        $this->assertDatabaseMissing('locals', ['uuid' => $this->localModel->uuid]);
    });

    it('should return false if local deletion failed', function () {
        $output = $this->repository->delete('invalid_uuid');
        expect($output)->toBeFalse();
    });

    it('should throw exception on local deletion error', function () {
        expect(function () {
            LocalModel::deleting(throw new \Exception('Error deleting local.'));
            $this->repository->delete($this->localModel->uuid);
        })->toThrow(new \Exception('Error deleting local.'));
    });
});
