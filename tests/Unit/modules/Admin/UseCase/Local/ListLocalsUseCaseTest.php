<?php

namespace Tests\Unit\Modules\Admin\UseCase\Local;

use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Admin\UseCase\Local\ListLocalsUseCase;

describe('ListLocalsUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockLocalRepository = \Mockery::mock(LocalGateway::class);
        $this->useCase = new ListLocalsUseCase($this->mockLocalRepository);

        $this->locals = [
            new Local(title: 'local_a_title', description: 'local_a_description'),
            new Local(title: 'local_b_title', description: 'local_b_description'),
        ];
    });

    it('should return all locals successfully', function () {
        $this->mockLocalRepository
            ->expects()
            ->list()
            ->andReturn($this->locals)
            ->once();

        $output = $this->useCase->execute();

        expect($output)->toHaveCount(count($this->locals));
        foreach ($this->locals as $key => $l) {
            expect($l->getId()->value)->toBe($this->locals[$key]->getId()->value);
            expect($l->getTitle())->toBe($this->locals[$key]->getTitle());
            expect($l->getDescription())->toBe($this->locals[$key]->getDescription());
        };
    });

    it('should return empty array if no local found', function () {
        $this->mockLocalRepository
            ->expects()
            ->list()
            ->andReturn([])
            ->once();

        $output = $this->useCase->execute();

        expect($output)->toBeEmpty();
    });

    it('should throw exception on repository error', function () {
        $this->mockLocalRepository
            ->expects()
            ->list()
            ->andThrow(new \Exception('Error getting locals.'))
            ->once();

        expect(fn () => $this->useCase->execute())
            ->toThrow(new \Exception('Error getting locals.'));
    });
});
