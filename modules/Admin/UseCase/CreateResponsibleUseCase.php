<?php

namespace Modules\Admin\UseCase;

use Modules\Admin\Domain\Entity\ResponsibleEntity;
use Modules\Admin\DTO\Responsible\CreateResponsibleInputDTO;
use Modules\Admin\DTO\Responsible\CreateResponsibleOutputDTO;
use Modules\Admin\Gateway\ResponsibleGateway;

class CreateResponsibleUseCase
{
    public function __construct(private ResponsibleGateway $responsibleRepository)
    {
    }

    public function execute(CreateResponsibleInputDTO $input): CreateResponsibleOutputDTO
    {
        $responsible = new ResponsibleEntity($input->name);

        $this->responsibleRepository->create($responsible);

        return new CreateResponsibleOutputDTO(
            id: $responsible->getId()->value,
            name: $responsible->getName(),
            createdAt: $responsible->getCreatedAt(),
            updatedAt: $responsible->getUpdatedAt(),
        );
    }
}
