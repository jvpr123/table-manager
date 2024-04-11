<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\Period as PeriodModel;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\Repository\PeriodRepository;

describe('PeriodRepository create() unit tests', function () {
    beforeEach(function () {
        $this->period = new Period(time: $this->time = now()->format('H:i'));
        $this->repository = new PeriodRepository();
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

describe('PeriodRepository find() unit tests', function () {
    beforeEach(function () {
        $this->periodEntity = new Period(time: $this->time = now());
        $this->periodId = $this->periodEntity->getId()->value;
        $this->periodModel = PeriodModel::factory()->create([
            'uuid' => $this->periodEntity->getId()->value,
            'time' => $this->periodEntity->getTime(),
            'created_at' => $this->periodEntity->getCreatedAt(),
            'updated_at' => $this->periodEntity->getUpdatedAt(),
        ]);

        $this->repository = new PeriodRepository();
    });

    it('should retrieve a period from database successfully', function () {
        $output = $this->repository->find($this->periodId);
        expect($output)->toBeInstanceOf(Period::class);
        expect($output->getId()->value)->toBe($this->periodId);
    });

    it('should return null if period not found', function () {
        expect($this->repository->find(id: ''))->toBeNull();
    });
});
