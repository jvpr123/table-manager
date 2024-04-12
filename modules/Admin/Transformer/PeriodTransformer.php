<?php

namespace Modules\Admin\Transformer;

use App\Models\Period as PeriodModel;
use Modules\Admin\Domain\Entity\Period;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\Transformer\BaseTransformer;
use Modules\Shared\Domain\ValueObject\UUID;

class PeriodTransformer implements BaseTransformer
{
    /**
     * @param PeriodModel $period
     * @return Period
     */
    public function transform(object $period): BaseEntity
    {
        return new Period(
            id: new UUID($period->uuid),
            time: $period->time,
            createdAt: $period->created_at,
            updatedAt: $period->updated_at,
        );
    }
}
