<?php

namespace Modules\Admin\UseCase\Local;

use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\DTO\Local\LocalOutputDTO;
use Modules\Admin\Gateway\LocalGateway;

class ListLocalsUseCase
{
    public function __construct(private LocalGateway $localRepository)
    {
    }

    /**
     * @return LocalOutputDTO[]
     */
    public function execute(): array
    {
        $locals = $this->localRepository->list();

        return array_map(fn (Local $local) => new LocalOutputDTO(
            id: $local->getId()->value,
            title: $local->getTitle(),
            description: $local->getDescription(),
            createdAt: $local->getCreatedAt(),
            updatedAt: $local->getUpdatedAt(),
        ), $locals);
    }
}
