<?php

namespace Tests\Unit\Modules\Admin\UseCase;

use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\DTO\Responsible\ResponsibleOutputDTO;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\UseCase\FindResponsibleByIdUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('FindResponsibleByIdUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockResponsibleRepository = \Mockery::mock(ResponsibleGateway::class);
        $this->useCase = new FindResponsibleByIdUseCase($this->mockResponsibleRepository);

        $this->responsible = new Responsible('responsible_name');
        $this->responsibleId = $this->responsible->getId()->value;
    });

    it('should return a responsible successfully', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->responsibleId)
            ->andReturn($this->responsible)
            ->once();

        $output = $this->useCase->execute($this->responsibleId);

        expect($output)->toBeInstanceOf(ResponsibleOutputDTO::class);
        expect($output->id)->toBe($this->responsible->getId()->value);
    });

    it('should throw exception if responsible not found', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->responsibleId)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->responsibleId))
            ->toThrow(new EntityNotFoundException('Responsible', $this->responsibleId));
    });

    it('should throw exception on repository error', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->responsibleId)
            ->andThrow(new \Exception('Error getting responsible.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->responsibleId))
            ->toThrow(new \Exception('Error getting responsible.'));
    });
});
