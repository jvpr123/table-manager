<?php

namespace Modules\Admin\UseCase\Local;

use Modules\Admin\Gateway\LocalGateway;
use Modules\Shared\Exceptions\EntityNotFoundException;

class DeleteLocalUseCase
{
    public function __construct(private LocalGateway $localRepository)
    {
    }

    public function execute(string $id): void
    {
        $local = $this->localRepository->find($id);

        if (!$local) {
            throw new EntityNotFoundException('Local', $id);
        }

        $this->localRepository->delete($id);
    }
}
