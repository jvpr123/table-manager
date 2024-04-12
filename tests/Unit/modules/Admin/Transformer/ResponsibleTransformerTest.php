<?php

namespace Tests\Unit\Modules\Admin\Transformer;

use App\Models\Responsible as ResponsibleModel;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\Transformer\ResponsibleTransformer;

describe('ResponsibleTransformer unit tests', function () {
    beforeEach(function () {
        $this->transformer = new ResponsibleTransformer();

        $this->responsibleEntity = new Responsible(name: 'responsible_name');
        $this->responsibleModel = ResponsibleModel::factory()->create([
            'uuid' => $this->responsibleEntity->getId()->value,
            'name' => $this->responsibleEntity->getName(),
            'created_at' => $this->responsibleEntity->getCreatedAt(),
            'updated_at' => $this->responsibleEntity->getUpdatedAt(),
        ]);
    });

    it('should transform responsible model into entity successfully', function () {
        $output = $this->transformer->transform($this->responsibleModel);
        expect($output)->toBeInstanceOf(Responsible::class);
    });
});
