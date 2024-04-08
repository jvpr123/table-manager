<?php

namespace Modules\Admin\UseCase\Local;

use Modules\Admin\DTO\Local\LocalOutputDTO;
use Modules\Admin\DTO\Local\UpdateLocalInputDTO;
use Modules\Admin\Gateway\LocalGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class UpdateLocalUseCase
{
    public function __construct(private LocalGateway $localRepository)
    {
    }

    public function execute(UpdateLocalInputDTO $input): LocalOutputDTO
    {
        $local = $this->localRepository->find($input->id);

        if (!$local) {
            throw new EntityNotFoundException('Local', $input->id);
        }

        $local->setTitle($input->title);
        $local->setDescription($input->description);
        $local->setUpdatedAt(now());

        $this->localRepository->update($local);

        return new LocalOutputDTO(
            id: $local->getId()->value,
            title: $local->getTitle(),
            description: $local->getDescription(),
            createdAt: $local->getCreatedAt(),
            updatedAt: $local->getUpdatedAt(),
        );
    }
}
