<?php

namespace Tests\Unit\Modules\Admin\Transformer;

use App\Models\Period as PeriodModel;
use Modules\Admin\Domain\Entity\Period;
use Modules\Admin\Transformer\PeriodTransformer;

describe('PeriodTransformer unit tests', function () {
    beforeEach(function () {
        $this->transformer = new PeriodTransformer();

        $this->periodEntity = new Period(time: '8:00');
        $this->periodModel = PeriodModel::factory()->create([
            'uuid' => $this->periodEntity->getId()->value,
            'time' => $this->periodEntity->getTime(),
            'created_at' => $this->periodEntity->getCreatedAt(),
            'updated_at' => $this->periodEntity->getUpdatedAt(),
        ]);
    });

    it('should transform period model into entity successfully', function () {
        $output = $this->transformer->transform($this->periodModel);
        expect($output)->toBeInstanceOf(Period::class);
    });
});
