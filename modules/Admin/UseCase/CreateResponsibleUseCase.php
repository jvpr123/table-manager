<?php

namespace Modules\Admin\UseCase;

use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\DTO\Responsible\CreateResponsibleInputDTO;
use Modules\Admin\DTO\Responsible\ResponsibleOutputDTO;
use Modules\Admin\Gateway\ResponsibleGateway;

class CreateResponsibleUseCase
{
    public function __construct(private ResponsibleGateway $responsibleRepository)
    {
    }

    public function execute(CreateResponsibleInputDTO $input): ResponsibleOutputDTO
    {
        $responsible = new Responsible($input->name);

        $this->responsibleRepository->create($responsible);

        return new ResponsibleOutputDTO(
            id: $responsible->getId()->value,
            name: $responsible->getName(),
            createdAt: $responsible->getCreatedAt(),
            updatedAt: $responsible->getUpdatedAt(),
        );
    }
}
