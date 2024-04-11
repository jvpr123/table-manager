<?php

namespace Tests\Unit\Modules\Admin\UseCase\Period;

use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\DTO\Period\PeriodOutputDTO;
use Modules\Admin\DTO\Period\UpdatePeriodInputDTO;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Admin\UseCase\Period\UpdatePeriodUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('UpdatePeriodUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockPeriodRepository = \Mockery::mock(PeriodGateway::class);
        $this->useCase = new UpdatePeriodUseCase($this->mockPeriodRepository);

        $this->time = now();
        $this->period = new Period($this->time->format('H:i'));
        $this->input = new UpdatePeriodInputDTO(
            id: $this->period->getId()->value,
            time: $this->time->addHour()->format('H:i'),
        );
    });

    it('should update a period successfully', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->input->id)
            ->andReturn($this->period)
            ->once();

        $this->mockPeriodRepository
            ->expects()
            ->update(\Mockery::type(Period::class))
            ->once();

        $output = $this->useCase->execute($this->input);

        expect($output)->toBeInstanceOf(PeriodOutputDTO::class);
        expect($output->id)->toBe($this->input->id);
        expect($output->time)->toBe($this->input->time);
        expect($output->createdAt->toString())->toBe($this->period->getCreatedAt()->toString());
        expect($output->updatedAt->toString())->toBe(now()->toString());
    });

    it('should throw an exception if period not found', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->input->id)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new EntityNotFoundException('Period', $this->input->id));
    });

    it('should throw exception on getting period error', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->input->id)
            ->andThrow(new \Exception('Error getting period.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(\Exception::class, 'Error getting period.');
    });

    it('should throw exception on updating period error', function () {
        $this->mockPeriodRepository
            ->expects()
            ->find($this->input->id)
            ->andReturn($this->period)
            ->once();

        $this->mockPeriodRepository
            ->expects()
            ->update(\Mockery::type(Period::class))
            ->andThrow(new \Exception('Error updating period.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new \Exception('Error updating period.'));
    });
});
