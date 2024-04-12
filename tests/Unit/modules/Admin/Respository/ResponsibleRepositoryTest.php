<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\Responsible as ResponsibleModel;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\Repository\ResponsibleRepository;
use Modules\Admin\Transformer\ResponsibleTransformer;

describe('ResponsibleRepository create() unit tests', function () {
    beforeEach(function () {
        $this->transformer = \Mockery::mock(ResponsibleTransformer::class);
        $this->repository = new ResponsibleRepository($this->transformer);

        $this->responsible = new Responsible('responsible_name');
    });

    it('should register a responsible in database successfully', function () {
        $output = $this->repository->create($this->responsible);

        expect($output)->toBeNull();
        $this->assertDatabaseHas('responsibles', [
            'uuid' => $this->responsible->getId()->value,
            'name' => $this->responsible->getName(),
            'created_at' => $this->responsible->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->responsible->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);
    });

    it('should throw exception on responsible saving error', function () {
        expect(function () {
            ResponsibleModel::saving(throw new \Exception('Error saving responsible.'));
            $this->repository->create($this->responsible);
        })->toThrow(new \Exception('Error saving responsible.'));

        $this->assertDatabaseMissing('responsibles', ['uuid' => $this->responsible->getId()->value]);
    });
});

describe('ResponsibleRepository update() unit tests', function () {
    beforeEach(function () {
        $this->transformer = \Mockery::mock(ResponsibleTransformer::class);
        $this->repository = new ResponsibleRepository($this->transformer);

        $this->responsibleEntity = new Responsible('responsible_name');
    });

    it('should return true if responsible update succeeded', function () {
        $this->responsibleModel = ResponsibleModel::factory()->create([
            'uuid' => $this->responsibleEntity->getId()->value,
            'name' => $this->responsibleEntity->getName(),
            'created_at' => $this->responsibleEntity->getCreatedAt(),
            'updated_at' => $this->responsibleEntity->getUpdatedAt(),
        ]);

        $this->responsibleEntity->setName($name = 'updated_name');
        $this->responsibleEntity->setUpdatedAt($date = now()->addDay());

        $output = $this->repository->update($this->responsibleEntity);

        expect($output)->toBeTrue();
        $this->assertDatabaseHas('responsibles', [
            'uuid' => $this->responsibleModel->uuid,
            'name' => $name,
            'updated_at' => $date->format('Y-m-d H:i:s'),
            'created_at' => $this->responsibleModel->created_at,
        ]);
    });

    it('should return false if responsible deletion failed', function () {
        $output = $this->repository->update($this->responsibleEntity);
        expect($output)->toBeFalse();
    });

    it('should throw exception on responsible update error', function () {
        expect(function () {
            ResponsibleModel::updating(throw new \Exception('Error updating responsible.'));
            $this->repository->update($this->responsibleEntity);
        })->toThrow(new \Exception('Error updating responsible.'));
    });
});

describe('ResponsibleRepository find() unit tests', function () {
    beforeEach(function () {
        $this->responsibleEntity = new Responsible('responsible_name');
        $this->responsibleId = $this->responsibleEntity->getId()->value;
        $this->responsibleModel = ResponsibleModel::factory()->create([
            'uuid' => $this->responsibleEntity->getId()->value,
            'name' => $this->responsibleEntity->getName(),
            'created_at' => $this->responsibleEntity->getCreatedAt(),
            'updated_at' => $this->responsibleEntity->getUpdatedAt(),
        ]);

        $this->transformer = \Mockery::mock(ResponsibleTransformer::class);
        $this->repository = new ResponsibleRepository($this->transformer);
    });

    it('should retrieve a responsible from database successfully', function () {
        $this->transformer->expects()
            ->transform(\Mockery::type(ResponsibleModel::class))
            ->andReturn($this->responsibleEntity)
            ->once();

        $output = $this->repository->find($this->responsibleId);
        expect($output)->toBeInstanceOf(Responsible::class);
        expect($output->getId()->value)->toBe($this->responsibleId);
    });

    it('should return null if responsible not found', function () {
        expect($this->repository->find(''))->toBeNull();
    });
});

describe('ResponsibleRepository list() unit tests', function () {
    beforeEach(function () {
        $this->transformer = \Mockery::mock(ResponsibleTransformer::class);
        $this->repository = new ResponsibleRepository($this->transformer);
    });

    it('should retrieve all responsibles from database successfully', function () {
        $responsibleEntities = [
            new Responsible('responsible_a'),
            new Responsible('responsible_b'),
        ];

        foreach ($responsibleEntities as $re) {
            ResponsibleModel::factory()->create([
                'uuid' => $re->getId()->value,
                'name' => $re->getName(),
                'created_at' => $re->getCreatedAt(),
                'updated_at' => $re->getUpdatedAt(),
            ]);

            $this->transformer->expects()
                ->transform(\Mockery::type(ResponsibleModel::class))
                ->andReturn($re)
                ->once();
        }

        $output = $this->repository->list();
        expect($output)->toHaveCount(count($responsibleEntities));
    });

    it('should return empty array if no responsible found', function () {
        expect($this->repository->list())->toBeEmpty();
    });
});

describe('ResponsibleRepository delete() unit tests', function () {
    beforeEach(function () {
        $this->transformer = \Mockery::mock(ResponsibleTransformer::class);
        $this->repository = new ResponsibleRepository($this->transformer);

        $this->responsibleModel = ResponsibleModel::factory()->create(['uuid' => uuid_create()]);
    });

    it('should return true if responsible deletion succeeded', function () {
        $this->assertDatabaseHas('responsibles', ['uuid' => $this->responsibleModel->uuid]);

        $output = $this->repository->delete($this->responsibleModel->uuid);

        expect($output)->toBeTrue();
        $this->assertDatabaseMissing('responsibles', ['uuid' => $this->responsibleModel->uuid]);
    });

    it('should return false if responsible deletion failed', function () {
        $output = $this->repository->delete('invalid_uuid');
        expect($output)->toBeFalse();
    });

    it('should throw exception on responsible deletion error', function () {
        expect(function () {
            ResponsibleModel::deleting(throw new \Exception('Error deleting responsible.'));
            $this->repository->delete($this->responsibleModel->uuid);
        })->toThrow(new \Exception('Error deleting responsible.'));
    });
});
