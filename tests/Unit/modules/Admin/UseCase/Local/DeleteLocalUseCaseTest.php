<?php

namespace Tests\Unit\Modules\Admin\UseCase\Local;

use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Admin\UseCase\Local\DeleteLocalUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('DeleteLocalUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockLocalRepository = \Mockery::mock(LocalGateway::class);
        $this->useCase = new DeleteLocalUseCase($this->mockLocalRepository);

        $this->local = new Local(title: 'local_title', description: 'local_description');
        $this->localId = $this->local->getId()->value;
    });

    it('should delete a local successfully', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->localId)
            ->andReturn($this->local)
            ->once();

        $this->mockLocalRepository
            ->expects()
            ->delete($this->localId)
            ->once();

        $output = $this->useCase->execute($this->localId);

        expect($output)->toBeNull();
    });

    it('should throw an exception if local not found', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->localId)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->localId))
            ->toThrow(new EntityNotFoundException('Local', $this->localId));
    });

    it('should throw exception on getting local error', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->localId)
            ->andThrow(new \Exception('Error getting local.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->localId))
            ->toThrow(\Exception::class, 'Error getting local.');
    });

    it('should throw exception on deleting local error', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->localId)
            ->andReturn($this->local)
            ->once();

        $this->mockLocalRepository
            ->expects()
            ->delete($this->localId)
            ->andThrow(new \Exception('Error deleting local.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->localId))
            ->toThrow(new \Exception('Error deleting local.'));
    });
});
