<?php

namespace Tests\Unit\Modules\Admin\UseCase\Period;

use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Admin\UseCase\Period\ListPeriodsUseCase;

describe('ListPeriodsUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockPeriodRepository = \Mockery::mock(PeriodGateway::class);
        $this->useCase = new ListPeriodsUseCase($this->mockPeriodRepository);

        $this->periods = [
            new Period(Carbon::createFromFormat('H:i', '8:30')),
            new Period(Carbon::createFromFormat('H:i', '8:45')),
        ];
    });

    it('should return all periods successfully', function () {
        $this->mockPeriodRepository
            ->expects()
            ->list()
            ->andReturn($this->periods)
            ->once();

        $output = $this->useCase->execute();

        expect($output)->toHaveCount(count($this->periods));
        foreach ($this->periods as $key => $per) {
            expect($per->getId()->value)->toBe($this->periods[$key]->getId()->value);
            expect($per->getTime())->toBe($this->periods[$key]->getTime());
        };
    });

    it('should return empty array if no responsible found', function () {
        $this->mockPeriodRepository
            ->expects()
            ->list()
            ->andReturn([])
            ->once();

        $output = $this->useCase->execute();

        expect($output)->toBeEmpty();
    });

    it('should throw exception on repository error', function () {
        $this->mockPeriodRepository
            ->expects()
            ->list()
            ->andThrow(new \Exception('Error getting periods.'))
            ->once();

        expect(fn () => $this->useCase->execute())
            ->toThrow(new \Exception('Error getting periods.'));
    });
});
