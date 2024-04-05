<?php

namespace Tests\Unit\Modules\Admin\UseCase\Responsible;

use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\UseCase\Responsible\DeleteResponsibleUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('DeleteResponsibleUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockResponsibleRepository = \Mockery::mock(ResponsibleGateway::class);
        $this->useCase = new DeleteResponsibleUseCase($this->mockResponsibleRepository);

        $this->responsible = new Responsible('responsible_name');
        $this->responsibleId = $this->responsible->getId()->value;
    });

    it('should delete a responsible successfully', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->responsibleId)
            ->andReturn($this->responsible)
            ->once();

        $this->mockResponsibleRepository
            ->expects()
            ->delete($this->responsibleId)
            ->once();

        $output = $this->useCase->execute($this->responsibleId);

        expect($output)->toBeNull();
    });

    it('should throw an exception if responsible not found', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->responsibleId)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->responsibleId))
            ->toThrow(new EntityNotFoundException('Responsible', $this->responsibleId));
    });

    it('should throw exception on getting responsible error', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->responsibleId)
            ->andThrow(new \Exception('Error getting responsible.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->responsibleId))
            ->toThrow(\Exception::class, 'Error getting responsible.');
    });

    it('should throw exception on deleting responsible error', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->responsibleId)
            ->andReturn($this->responsible)
            ->once();

        $this->mockResponsibleRepository
            ->expects()
            ->delete($this->responsibleId)
            ->andThrow(new \Exception('Error deleting responsible.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->responsibleId))
            ->toThrow(new \Exception('Error deleting responsible.'));
    });
});
