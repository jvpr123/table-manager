<?php

namespace Tests\Unit\Modules\Admin\UseCase\Local;

use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\DTO\Local\CreateLocalInputDTO;
use Modules\Admin\DTO\Local\LocalOutputDTO;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Admin\UseCase\Local\CreateLocalUseCase;

describe('CreateLocalUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockLocalRepository = \Mockery::mock(LocalGateway::class);
        $this->useCase = new CreateLocalUseCase($this->mockLocalRepository);

        $this->input = new CreateLocalInputDTO(
            title: 'local_title',
            description: 'local_description',
        );
    });

    it('should create a local successfully', function () {
        $this->mockLocalRepository
            ->expects()
            ->create(\Mockery::type(Local::class))
            ->once();

        $output = $this->useCase->execute($this->input);

        expect($output)->toBeInstanceOf(LocalOutputDTO::class);
        expect($output->id)->toBeString();
        expect($output->title)->toBe($this->input->title);
        expect($output->createdAt->toString())->toBe(now()->toString());
        expect($output->updatedAt->toString())->toBe(now()->toString());
    });

    it('should throw exception on creating local error', function () {
        $this->mockLocalRepository
            ->expects()
            ->create(\Mockery::type(Local::class))
            ->andThrow(new \Exception('Error creating local.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new \Exception('Error creating local.'));
    });
});
