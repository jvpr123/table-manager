<?php

namespace Modules\Admin\Transformer;

use App\Models\Local as LocalModel;
use Modules\Admin\Domain\Entity\Local;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\Transformer\BaseTransformer;
use Modules\Shared\Domain\ValueObject\UUID;

class LocalTransformer implements BaseTransformer
{
    /**
     * @param LocalModel $local
     * @return Local
     */
    public function transform(object $local): BaseEntity
    {
        return new Local(
            id: new UUID($local->uuid),
            title: $local->title,
            description: $local->description,
            createdAt: $local->created_at,
            updatedAt: $local->updated_at,
        );
    }
}
