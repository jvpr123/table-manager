<?php

namespace Tests\Unit\Modules\Admin\UseCase\Responsible;

use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\DTO\Responsible\ResponsibleOutputDTO;
use Modules\Admin\DTO\Responsible\UpdateResponsibleInputDTO;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\UseCase\Responsible\UpdateResponsibleUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('UpdateResponsibleUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockResponsibleRepository = \Mockery::mock(ResponsibleGateway::class);
        $this->useCase = new UpdateResponsibleUseCase($this->mockResponsibleRepository);

        $this->responsible = new Responsible('responsible_name');
        $this->input = new UpdateResponsibleInputDTO(
            id: $this->responsible->getId()->value,
            name: 'responsible_name',
        );
    });

    it('should update a responsible successfully', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->input->id)
            ->andReturn($this->responsible)
            ->once();

        $this->mockResponsibleRepository
            ->expects()
            ->update(\Mockery::type(Responsible::class))
            ->once();

        $output = $this->useCase->execute($this->input);

        expect($output)->toBeInstanceOf(ResponsibleOutputDTO::class);
        expect($output->id)->toBe($this->input->id);
        expect($output->name)->toBe($this->input->name);
        expect($output->createdAt->toString())->toBe($this->responsible->getCreatedAt()->toString());
        expect($output->updatedAt->toString())->toBe(now()->toString());
    });

    it('should throw an exception if responsible not found', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->input->id)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new EntityNotFoundException('Responsible', $this->input->id));
    });

    it('should throw exception on getting responsible error', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->input->id)
            ->andThrow(new \Exception('Error getting responsible.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(\Exception::class, 'Error getting responsible.');
    });

    it('should throw exception on updating responsible error', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->find($this->input->id)
            ->andReturn($this->responsible)
            ->once();

        $this->mockResponsibleRepository
            ->expects()
            ->update(\Mockery::type(Responsible::class))
            ->andThrow(new \Exception('Error updating responsible.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new \Exception('Error updating responsible.'));
    });
});
