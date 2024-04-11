<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\Period as PeriodModel;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\Repository\PeriodRepository;

describe('PeriodRepository create unit tests', function () {
    beforeEach(function () {
        $this->period = new Period(time: $this->time = now());
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
