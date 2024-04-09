<?php

namespace Modules\Admin\UseCase\Period;

use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\DTO\Period\PeriodOutputDTO;
use Modules\Admin\Gateway\PeriodGateway;

class ListPeriodsUseCase
{
    public function __construct(private PeriodGateway $periodRepository)
    {
    }

    /**
     * @return PeriodOutputDTO[]
     */
    public function execute(): array
    {
        $periods = $this->periodRepository->list();

        return array_map(fn (Period $period) => new PeriodOutputDTO(
            id: $period->getId()->value,
            time: $period->getTime(),
            createdAt: $period->getCreatedAt(),
            updatedAt: $period->getUpdatedAt(),
        ), $periods);
    }
}
