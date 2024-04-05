<?php

namespace Modules\Admin\UseCase\Local;

use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\DTO\Local\CreateLocalInputDTO;
use Modules\Admin\DTO\Local\LocalOutputDTO;
use Modules\Admin\Gateway\LocalGateway;

class CreateLocalUseCase
{
    public function __construct(private LocalGateway $localRepository)
    {
    }

    public function execute(CreateLocalInputDTO $input): LocalOutputDTO
    {
        $local = new Local(title: $input->title, description: $input->description);

        $this->localRepository->create($local);

        return new LocalOutputDTO(
            id: $local->getId()->value,
            title: $local->getTitle(),
            description: $local->getDescription(),
            createdAt: $local->getCreatedAt(),
            updatedAt: $local->getUpdatedAt(),
        );
    }
}
