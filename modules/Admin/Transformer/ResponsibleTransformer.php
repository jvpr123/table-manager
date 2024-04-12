<?php

namespace Modules\Admin\Transformer;

use App\Models\Responsible as ResponsibleModel;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\Transformer\BaseTransformer;
use Modules\Shared\Domain\ValueObject\UUID;

class ResponsibleTransformer implements BaseTransformer
{
    /**
     * @param ResponsibleModel $responsible
     * @return Responsible
     */
    public function transform(object $responsible): BaseEntity
    {
        return new Responsible(
            id: new UUID($responsible->uuid),
            name: $responsible->name,
            createdAt: $responsible->created_at,
            updatedAt: $responsible->updated_at,
        );
    }
}
