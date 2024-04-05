<?php

namespace Tests\Unit\Modules\Admin\UseCase\Responsible;

use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Admin\UseCase\Responsible\ListResponsiblesUseCase;

describe('ListResponsiblesUseCase unit tests', function () {
    beforeEach(function () {
        $this->mockResponsibleRepository = \Mockery::mock(ResponsibleGateway::class);
        $this->useCase = new ListResponsiblesUseCase($this->mockResponsibleRepository);

        $this->responsibles = [
            new Responsible('responsible_a'),
            new Responsible('responsible_b'),
        ];
    });

    it('should return all responsibles successfully', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->list()
            ->andReturn($this->responsibles)
            ->once();

        $output = $this->useCase->execute();

        expect($output)->toHaveCount(count($this->responsibles));
        foreach ($this->responsibles as $key => $res) {
            expect($res->getId()->value)->toBe($this->responsibles[$key]->getId()->value);
            expect($res->getName())->toBe($this->responsibles[$key]->getName());
        };
    });

    it('should return empty array if no responsible found', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->list()
            ->andReturn([])
            ->once();

        $output = $this->useCase->execute();

        expect($output)->toBeEmpty();
    });

    it('should throw exception on repository error', function () {
        $this->mockResponsibleRepository
            ->expects()
            ->list()
            ->andThrow(new \Exception('Error getting responsibles.'))
            ->once();

        expect(fn () => $this->useCase->execute())
            ->toThrow(new \Exception('Error getting responsibles.'));
    });
});
