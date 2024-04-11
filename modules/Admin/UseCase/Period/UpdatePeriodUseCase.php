<?php

namespace Modules\Admin\UseCase\Period;

use Carbon\Carbon;
use Modules\Admin\DTO\Period\PeriodOutputDTO;
use Modules\Admin\DTO\Period\UpdatePeriodInputDTO;
use Modules\Admin\Gateway\PeriodGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class UpdatePeriodUseCase
{
    public function __construct(private PeriodGateway $periodRepository)
    {
    }

    public function execute(UpdatePeriodInputDTO $input): PeriodOutputDTO
    {
        $period = $this->periodRepository->find($input->id);

        if (!$period) {
            throw new EntityNotFoundException('Period', $input->id);
        }

        $period->setTime($input->time);
        $period->setUpdatedAt(now());

        $this->periodRepository->update($period);

        return new PeriodOutputDTO(
            id: $period->getId()->value,
            time: $period->getTime(),
            createdAt: $period->getCreatedAt(),
            updatedAt: $period->getUpdatedAt(),
        );
    }
}
