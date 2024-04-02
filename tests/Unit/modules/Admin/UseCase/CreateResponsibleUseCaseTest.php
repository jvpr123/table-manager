<?php

namespace Tests\Unit\Modules\Admin\UseCase;

use Modules\Admin\Domain\Entity\ResponsibleEntity;
use Modules\Admin\DTO\Responsible\CreateResponsibleInputDTO;
use Modules\Admin\DTO\Responsible\CreateResponsibleOutputDTO;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\UseCase\CreateResponsibleUseCase;

describe('CreateResponsibleUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockResponsibleRepository = \Mockery::mock(ResponsibleGateway::class);
        $this->useCase = new CreateResponsibleUseCase($this->mockResponsibleRepository);
        $this->input = new CreateResponsibleInputDTO('responsible_name');
    });

    it('should create a responsible successfully', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->create(\Mockery::type(ResponsibleEntity::class))
            ->once();

        $output = $this->useCase->execute($this->input);

        expect($output)->toBeInstanceOf(CreateResponsibleOutputDTO::class);
        expect($output->id)->toBeString();
        expect($output->name)->toBe($this->input->name);
        expect($output->createdAt->toString())->toBe(now()->toString());
        expect($output->updatedAt->toString())->toBe(now()->toString());
    });

    it('should throw exception on repository error', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->create(\Mockery::type(ResponsibleEntity::class))
            ->andThrow(new \Exception('Repository error.'))
            ->once();

        $this->useCase->execute($this->input);
    })->throws(\Exception::class, 'Repository error.');
});
