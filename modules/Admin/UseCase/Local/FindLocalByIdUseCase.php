<?php

namespace Modules\Admin\UseCase\Local;

use Modules\Admin\DTO\Local\LocalOutputDTO;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class FindLocalByIdUseCase
{
    public function __construct(private LocalGateway $localRepository)
    {
    }

    public function execute(string $id): LocalOutputDTO
    {
        $local = $this->localRepository->find($id);

        if (!$local) {
            throw new EntityNotFoundException('Local', $id);
        }

        return new LocalOutputDTO(
            id: $local->getId()->value,
            title: $local->getTitle(),
            description: $local->getDescription(),
            createdAt: $local->getCreatedAt(),
            updatedAt: $local->getUpdatedAt(),
        );
    }
}
