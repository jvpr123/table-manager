<?php

namespace Tests\Unit\Modules\Admin\UseCase\Period;

use Carbon\Carbon;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\DTO\Period\CreatePeriodInputDTO;
use Modules\Admin\DTO\Period\PeriodOutputDTO;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Admin\UseCase\Period\CreatePeriodUseCase;

describe('CreatePeriodUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockPeriodRepository = \Mockery::mock(PeriodGateway::class);
        $this->useCase = new CreatePeriodUseCase($this->mockPeriodRepository);
        $this->input = new CreatePeriodInputDTO(Carbon::createFromFormat('H:i', '8:30')->format('H:i'));
    });

    it('should create a period successfully', function () {
        $this->mockPeriodRepository
            ->expects()
            ->create(\Mockery::type(Period::class))
            ->once();

        $output = $this->useCase->execute($this->input);

        expect($output)->toBeInstanceOf(PeriodOutputDTO::class);
        expect($output->id)->toBeString();
        expect($output->time)->toBe($this->input->time);
        expect($output->createdAt->toString())->toBe(now()->toString());
        expect($output->updatedAt->toString())->toBe(now()->toString());
    });

    it('should throw exception on creating period error', function () {
        $this->mockPeriodRepository
            ->expects()
            ->create(\Mockery::type(Period::class))
            ->andThrow(new \Exception('Error creating period.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new \Exception('Error creating period.'));
    });
});
