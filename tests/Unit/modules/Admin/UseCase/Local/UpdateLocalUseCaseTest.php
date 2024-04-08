<?php

namespace Tests\Unit\Modules\Admin\UseCase\Local;

use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\DTO\Local\LocalOutputDTO;
use Modules\Admin\DTO\Local\UpdateLocalInputDTO;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Admin\UseCase\Local\UpdateLocalUseCase;
use Modules\Shared\Exceptions\EntityNotFoundException;

describe('UpdateLocalUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockLocalRepository = \Mockery::mock(LocalGateway::class);
        $this->useCase = new UpdateLocalUseCase($this->mockLocalRepository);

        $this->local = new Local(title: 'local_title', description: 'local_description');
        $this->input = new UpdateLocalInputDTO(
            id: $this->local->getId()->value,
            title: 'local_title',
            description: 'local_description',
        );
    });

    it('should update a local successfully', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->input->id)
            ->andReturn($this->local)
            ->once();

        $this->mockLocalRepository
            ->expects()
            ->update(\Mockery::type(Local::class))
            ->once();

        $output = $this->useCase->execute($this->input);

        expect($output)->toBeInstanceOf(LocalOutputDTO::class);
        expect($output->id)->toBe($this->input->id);
        expect($output->title)->toBe($this->input->title);
        expect($output->description)->toBe($this->input->description);
        expect($output->createdAt->toString())->toBe($this->local->getCreatedAt()->toString());
        expect($output->updatedAt->toString())->toBe(now()->toString());
    });

    it('should throw an exception if local not found', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->input->id)
            ->andReturnNull()
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new EntityNotFoundException('Local', $this->input->id));
    });

    it('should throw exception on getting local error', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->input->id)
            ->andThrow(new \Exception('Error getting local.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(\Exception::class, 'Error getting local.');
    });

    it('should throw exception on updating local error', function () {
        $this->mockLocalRepository
            ->expects()
            ->find($this->input->id)
            ->andReturn($this->local)
            ->once();

        $this->mockLocalRepository
            ->expects()
            ->update(\Mockery::type(Local::class))
            ->andThrow(new \Exception('Error updating local.'))
            ->once();

        expect(fn () => $this->useCase->execute($this->input))
            ->toThrow(new \Exception('Error updating local.'));
    });
});
