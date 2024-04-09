<?php

namespace Modules\Admin\UseCase\Period;

use Modules\Admin\Gateway\PeriodGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class DeletePeriodUseCase
{
    public function __construct(private PeriodGateway $periodRepository)
    {
    }

    public function execute(string $id): void
    {
        $period = $this->periodRepository->find($id);

        if (!$period) {
            throw new EntityNotFoundException('Period', $id);
        }

        $this->periodRepository->delete($id);
    }
}
