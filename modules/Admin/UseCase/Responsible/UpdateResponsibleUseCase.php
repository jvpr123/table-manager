<?php

namespace Modules\Admin\UseCase\Responsible;

use Modules\Admin\DTO\Responsible\UpdateResponsibleInputDTO;
use Modules\Admin\DTO\Responsible\ResponsibleOutputDTO;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class UpdateResponsibleUseCase
{
    public function __construct(private ResponsibleGateway $responsibleRepository)
    {
    }

    public function execute(UpdateResponsibleInputDTO $input): ResponsibleOutputDTO
    {
        $responsible = $this->responsibleRepository->find($input->id);

        if (!$responsible) {
            throw new EntityNotFoundException('Responsible', $input->id);
        }

        $responsible->setName($input->name ?: $responsible->getName());
        $responsible->setUpdatedAt(now());

        $this->responsibleRepository->update($responsible);

        return new ResponsibleOutputDTO(
            id: $responsible->getId()->value,
            name: $responsible->getName(),
            createdAt: $responsible->getCreatedAt(),
            updatedAt: $responsible->getUpdatedAt(),
        );
    }
}
