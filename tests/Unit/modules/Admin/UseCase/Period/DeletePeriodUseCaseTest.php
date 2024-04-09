<?php

namespace Tests\Unit\Modules\Admin\UseCase\Period;

use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Admin\UseCase\Period\DeletePeriodUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('DeletePeriodUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockPeriodRepository = \Mockery::mock(PeriodGateway::class);
        $this->useCase = new DeletePeriodUseCase($this->mockPeriodRepository);

        $this->period = new Period(Carbon::createFromFormat('H:i', '8:30'));
        $this->periodId = $this->period->getId()->value;
    });

    it('should delete a period successfully', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->periodId)
            ->andReturn($this->period)
            ->once();

        $this->mockPeriodRepository
            ->expects()
            ->delete($this->periodId)
            ->once();

        $output = $this->useCase->execute($this->periodId);

        expect($output)->toBeNull();
    });

    it('should throw an exception if period not found', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->periodId)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->periodId))
            ->toThrow(new EntityNotFoundException('Period', $this->periodId));
    });

    it('should throw exception on getting period error', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->periodId)
            ->andThrow(new \Exception('Error getting period.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->periodId))
            ->toThrow(\Exception::class, 'Error getting period.');
    });

    it('should throw exception on deleting period error', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->periodId)
            ->andReturn($this->period)
            ->once();

        $this->mockPeriodRepository
            ->expects()
            ->delete($this->periodId)
            ->andThrow(new \Exception('Error deleting period.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->periodId))
            ->toThrow(new \Exception('Error deleting period.'));
    });
});
