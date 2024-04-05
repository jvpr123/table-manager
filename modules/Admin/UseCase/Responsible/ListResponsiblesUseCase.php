<?php

namespace Modules\Admin\UseCase\Responsible;

use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\DTO\Responsible\ResponsibleOutputDTO;
use Modules\Admin\Gateway\ResponsibleGateway;

class ListResponsiblesUseCase
{
    public function __construct(private ResponsibleGateway $responsibleRepository)
    {
    }

    /**
     * @return ResponsibleOutputDTO[]
     */
    public function execute(): array
    {
        $responsibles = $this->responsibleRepository->list();

        return array_map(fn (Responsible $responsible) => new ResponsibleOutputDTO(
            id: $responsible->getId()->value,
            name: $responsible->getName(),
            createdAt: $responsible->getCreatedAt(),
            updatedAt: $responsible->getUpdatedAt(),
        ), $responsibles);
    }
}
