<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\Period as PeriodModel;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\Repository\PeriodRepository;
use Modules\Admin\Transformer\PeriodTransformer;

describe('PeriodRepository create() unit tests', function () {
    beforeEach(function () {
        $this->transformer = \Mockery::mock(PeriodTransformer::class);
        $this->repository = new PeriodRepository($this->transformer);

        $this->period = new Period(time: $this->time = now()->format('H:i'));
    });

    it('should register a period in database successfully', function () {
        $output = $this->repository->create($this->period);

        expect($output)->toBeNull();
        $this->assertDatabaseHas('periods', [
            'uuid' => $this->period->getId()->value,
            'time' => $this->period->getTime(),
            'created_at' => $this->period->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->period->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);
    });

    it('should throw exception on period saving error', function () {
        expect(function () {
            PeriodModel::saving(throw new \Exception('Error saving period.'));
            $this->repository->create($this->period);
        })->toThrow(new \Exception('Error saving period.'));

        $this->assertDatabaseMissing('periods', ['uuid' => $this->period->getId()->value]);
    });
});

describe('PeriodRepository update() unit tests', function () {
    beforeEach(function () {
        $this->transformer = \Mockery::mock(PeriodTransformer::class);
        $this->repository = new PeriodRepository($this->transformer);

        $this->periodEntity = new Period(time: '8:00');
    });

    it('should return true if period update succeeded', function () {
        $this->periodModel = PeriodModel::factory()->create([
            'uuid' => $this->periodEntity->getId()->value,
            'time' => $this->periodEntity->getTime(),
            'created_at' => $this->periodEntity->getCreatedAt(),
            'updated_at' => $this->periodEntity->getUpdatedAt(),
        ]);

        $this->periodEntity->setTime($time = '9:00');
        $this->periodEntity->setUpdatedAt($date = now()->addDay());

        $output = $this->repository->update($this->periodEntity);

        expect($output)->toBeTrue();
        $this->assertDatabaseHas('periods', [
            'uuid' => $this->periodModel->uuid,
            'time' => $time,
            'updated_at' => $date->format('Y-m-d H:i:s'),
            'created_at' => $this->periodModel->created_at,
        ]);
    });

    it('should return false if period deletion failed', function () {
        $output = $this->repository->update($this->periodEntity);
        expect($output)->toBeFalse();
    });

    it('should throw exception on period update error', function () {
        expect(function () {
            PeriodModel::updating(throw new \Exception('Error updating period.'));
            $this->repository->update($this->periodEntity);
        })->toThrow(new \Exception('Error updating period.'));
    });
});

describe('PeriodRepository find() unit tests', function () {
    beforeEach(function () {
        $this->transformer = \Mockery::mock(PeriodTransformer::class);
        $this->repository = new PeriodRepository($this->transformer);

        $this->periodEntity = new Period(time: $this->time = now());
        $this->periodId = $this->periodEntity->getId()->value;
        $this->periodModel = PeriodModel::factory()->create([
            'uuid' => $this->periodEntity->getId()->value,
            'time' => $this->periodEntity->getTime(),
            'created_at' => $this->periodEntity->getCreatedAt(),
            'updated_at' => $this->periodEntity->getUpdatedAt(),
        ]);
    });

    it('should retrieve a period from database successfully', function () {
        $this->transformer->expects()
            ->transform(\Mockery::type(PeriodModel::class))
            ->andReturn($this->periodEntity)
            ->once();

        $output = $this->repository->find($this->periodId);
        expect($output)->toBeInstanceOf(Period::class);
        expect($output->getId()->value)->toBe($this->periodId);
    });

    it('should return null if period not found', function () {
        expect($this->repository->find(id: ''))->toBeNull();
    });
});

describe('PeriodRepository list() unit tests', function () {
    beforeEach(function () {
        $this->transformer = \Mockery::mock(PeriodTransformer::class);
        $this->repository = new PeriodRepository($this->transformer);
    });

    it('should retrieve all periods from database successfully', function () {
        $periodEntities = [
            new Period(time: '8:30'),
            new Period(time: '9:00'),
        ];

        foreach ($periodEntities as $pe) {
            PeriodModel::factory()->create([
                'uuid' => $pe->getId()->value,
                'time' => $pe->getTime(),
                'created_at' => $pe->getCreatedAt(),
                'updated_at' => $pe->getUpdatedAt(),
            ]);

            $this->transformer->expects()
                ->transform(\Mockery::type(PeriodModel::class))
                ->andReturn($pe)
                ->once();
        }

        $output = $this->repository->list();
        expect($output)->toHaveCount(count($periodEntities));
    });

    it('should return empty array if no period found', function () {
        expect($this->repository->list())->toBeEmpty();
    });
});

describe('PeriodRepository delete() unit tests', function () {
    beforeEach(function () {
        $this->transformer = \Mockery::mock(PeriodTransformer::class);
        $this->repository = new PeriodRepository($this->transformer);

        $this->periodModel = PeriodModel::factory()->create(['uuid' => uuid_create()]);
    });

    it('should return true if period deletion succeeded', function () {
        $this->assertDatabaseHas('periods', ['uuid' => $this->periodModel->uuid]);

        $output = $this->repository->delete($this->periodModel->uuid);

        expect($output)->toBeTrue();
        $this->assertDatabaseMissing('periods', ['uuid' => $this->periodModel->uuid]);
    });

    it('should return false if period deletion failed', function () {
        $output = $this->repository->delete('invalid_uuid');
        expect($output)->toBeFalse();
    });

    it('should throw exception on period deletion error', function () {
        expect(function () {
            PeriodModel::deleting(throw new \Exception('Error deleting period.'));
            $this->repository->delete($this->periodModel->uuid);
        })->toThrow(new \Exception('Error deleting period.'));
    });
});
