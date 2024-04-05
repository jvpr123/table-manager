<?php

namespace Tests\Unit\Modules\Admin\UseCase\Responsible;

use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\DTO\Responsible\CreateResponsibleInputDTO;
use Modules\Admin\DTO\Responsible\ResponsibleOutputDTO;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\UseCase\Responsible\CreateResponsibleUseCase;

describe('CreateResponsibleUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockResponsibleRepository = \Mockery::mock(ResponsibleGateway::class);
        $this->useCase = new CreateResponsibleUseCase($this->mockResponsibleRepository);
        $this->input = new CreateResponsibleInputDTO('responsible_name');
    });

    it('should create a responsible successfully', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->create(\Mockery::type(Responsible::class))
            ->once();

        $output = $this->useCase->execute($this->input);

        expect($output)->toBeInstanceOf(ResponsibleOutputDTO::class);
        expect($output->id)->toBeString();
        expect($output->name)->toBe($this->input->name);
        expect($output->createdAt->toString())->toBe(now()->toString());
        expect($output->updatedAt->toString())->toBe(now()->toString());
    });

    it('should throw exception on creating responsible error', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->create(\Mockery::type(Responsible::class))
            ->andThrow(new \Exception('Error creating responsible.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new \Exception('Error creating responsible.'));
    });
});
