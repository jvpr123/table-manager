<?php

namespace Modules\Admin\UseCase\Period;

use Modules\Admin\DTO\Period\PeriodOutputDTO;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class FindPeriodByIdUseCase
{
    public function __construct(private PeriodGateway $periodRepository)
    {
    }

    public function execute(string $id): PeriodOutputDTO
    {
        $period = $this->periodRepository->find($id);

        if (!$period) {
            throw new EntityNotFoundException('Period', $id);
        }

        return new PeriodOutputDTO(
            id: $period->getId()->value,
            time: $period->getTime(),
            createdAt: $period->getCreatedAt(),
            updatedAt: $period->getUpdatedAt(),
        );
    }
}
