<?php

namespace Tests\Unit\Modules\Admin\UseCase\Local;

use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\DTO\Local\LocalOutputDTO;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Admin\UseCase\Local\FindLocalByIdUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('FindLocalByIdUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockLocalRepository = \Mockery::mock(LocalGateway::class);
        $this->useCase = new FindLocalByIdUseCase($this->mockLocalRepository);

        $this->local = new Local(title: 'local_title', description: 'local_description');
        $this->localId = $this->local->getId()->value;
    });

    it('should return a local successfully', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->localId)
            ->andReturn($this->local)
            ->once();

        $output = $this->useCase->execute($this->localId);

        expect($output)->toBeInstanceOf(LocalOutputDTO::class);
        expect($output->id)->toBe($this->local->getId()->value);
    });

    it('should throw exception if local not found', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->localId)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->localId))
            ->toThrow(new EntityNotFoundException('Local', $this->localId));
    });

    it('should throw exception on repository error', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->localId)
            ->andThrow(new \Exception('Error getting local.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->localId))
            ->toThrow(new \Exception('Error getting local.'));
    });
});
