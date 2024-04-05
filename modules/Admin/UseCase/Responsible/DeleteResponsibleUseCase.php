<?php

namespace Modules\Admin\UseCase\Responsible;

use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class DeleteResponsibleUseCase
{
    public function __construct(private ResponsibleGateway $responsibleRepository)
    {
    }

    public function execute(string $id): void
    {
        $responsible = $this->responsibleRepository->find($id);

        if (!$responsible) {
            throw new EntityNotFoundException('Responsible', $id);
        }

        $this->responsibleRepository->delete($id);
    }
}
