<?php

namespace Modules\Admin\UseCase\Period;

use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\DTO\Period\CreatePeriodInputDTO;
use Modules\Admin\DTO\Period\PeriodOutputDTO;
use Modules\Admin\Gateway\PeriodGateway;

class CreatePeriodUseCase
{
    public function __construct(private PeriodGateway $periodRepository)
    {
    }

    public function execute(CreatePeriodInputDTO $input): PeriodOutputDTO
    {
        $period = new Period($input->time);

        $this->periodRepository->create($period);

        return new PeriodOutputDTO(
            id: $period->getId()->value,
            time: $period->getTime(),
            createdAt: $period->getCreatedAt(),
            updatedAt: $period->getUpdatedAt(),
        );
    }
}
