<?php

namespace Modules\Admin\UseCase\Responsible;

use Modules\Admin\DTO\Responsible\ResponsibleOutputDTO;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class FindResponsibleByIdUseCase
{
    public function __construct(private ResponsibleGateway $responsibleRepository)
    {
    }

    public function execute(string $id): ResponsibleOutputDTO
    {
        $responsible = $this->responsibleRepository->find($id);

        if (!$responsible) {
            throw new EntityNotFoundException('Responsible', $id);
        }

        return new ResponsibleOutputDTO(
            id: $responsible->getId()->value,
            name: $responsible->getName(),
            createdAt: $responsible->getCreatedAt(),
            updatedAt: $responsible->getUpdatedAt(),
        );
    }
}
