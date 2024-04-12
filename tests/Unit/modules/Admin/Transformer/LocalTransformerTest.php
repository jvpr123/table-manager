<?php

namespace Tests\Unit\Modules\Admin\Transformer;

use App\Models\Local as LocalModel;
use Modules\Admin\Domain\Entity\Local;
use Modules\Admin\Transformer\LocalTransformer;

describe('LocalTransformer unit tests', function () {
    beforeEach(function () {
        $this->transformer = new LocalTransformer();

        $this->localEntity = new Local(title: 'local_name', description: 'local_description');
        $this->localModel = LocalModel::factory()->create([
            'uuid' => $this->localEntity->getId()->value,
            'title' => $this->localEntity->getTitle(),
            'description' => $this->localEntity->getDescription(),
            'created_at' => $this->localEntity->getCreatedAt(),
            'updated_at' => $this->localEntity->getUpdatedAt(),
        ]);
    });

    it('should transform local model into entity successfully', function () {
        $output = $this->transformer->transform($this->localModel);
        expect($output)->toBeInstanceOf(Local::class);
    });
});
