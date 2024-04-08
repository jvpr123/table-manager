<?php

namespace Tests\Unit\Modules\Admin\UseCase\Period;

use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\DTO\Period\PeriodOutputDTO;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Admin\UseCase\Period\FindPeriodByIdUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('FindPeriodByIdUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockPeriodRepository = \Mockery::mock(PeriodGateway::class);
        $this->useCase = new FindPeriodByIdUseCase($this->mockPeriodRepository);

        $this->period = new Period(Carbon::createFromFormat('H:i', '8:30'));
        $this->periodId = $this->period->getId()->value;
    });

    it('should return a period successfully', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->periodId)
            ->andReturn($this->period)
            ->once();

        $output = $this->useCase->execute($this->periodId);

        expect($output)->toBeInstanceOf(PeriodOutputDTO::class);
        expect($output->id)->toBe($this->period->getId()->value);
    });

    it('should throw exception if period not found', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->periodId)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->periodId))
            ->toThrow(new EntityNotFoundException('Period', $this->periodId));
    });

    it('should throw exception on repository error', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->periodId)
            ->andThrow(new \Exception('Error getting period.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->periodId))
            ->toThrow(new \Exception('Error getting period.'));
    });
});
