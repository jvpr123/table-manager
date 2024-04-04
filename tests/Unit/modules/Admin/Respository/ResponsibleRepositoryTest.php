<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\Responsible as ResponsibleModel;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\Repository\ResponsibleRepository;

describe('ResponsibleRepository create unit tests', function () {
    beforeEach(function () {
        $this->responsible = new Responsible('responsible_name');
        $this->repository = new ResponsibleRepository();
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

describe('ResponsibleRepository find unit tests', function () {
    beforeEach(function () {
        $this->responsibleEntity = new Responsible('responsible_name');
        $this->responsibleId = $this->responsibleEntity->getId()->value;
        $this->responsibleModel = ResponsibleModel::factory()->create([
            'uuid' => $this->responsibleEntity->getId()->value,
            'name' => $this->responsibleEntity->getName(),
            'created_at' => $this->responsibleEntity->getCreatedAt(),
            'updated_at' => $this->responsibleEntity->getUpdatedAt(),
        ]);

        $this->repository = new ResponsibleRepository();
    });

    it('should retrieve a responsible from database successfully', function () {
        $output = $this->repository->find($this->responsibleId);
        expect($output)->toBeInstanceOf(Responsible::class);
        expect($output->getId()->value)->toBe($this->responsibleId);
    });

    it('should return null if responsible not found', function () {
        expect($this->repository->find(''))->toBeNull();
    });
});

describe('ResponsibleRepository list unit tests', function () {
    beforeEach(fn () => $this->repository = new ResponsibleRepository());

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
        }

        $output = $this->repository->list();
        expect($output)->toHaveCount(count($responsibleEntities));
    });

    it('should return empty array if no responsible found', function () {
        expect($this->repository->list())->toBeEmpty();
    });
});

describe('ResponsibleRepository delete unit tests', function () {
    beforeEach(function () {
        $this->responsibleModel = ResponsibleModel::factory()->create(['uuid' => uuid_create()]);
        $this->repository = new ResponsibleRepository();
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
