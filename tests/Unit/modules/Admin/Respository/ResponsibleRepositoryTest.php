<?php

namespace Tests\Unit\Modules\Admin\Repository;

use App\Models\Responsible as ResponsibleModel;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\Repository\ResponsibleRepository;

describe('ResponsibleRepository create unit tests', function () {
    beforeEach(function () {
        $this->responsible = new Responsible('responsible_name');
        $this->repository = new ResponsibleRepository();
    });

    it('should register a responsible in database successfully', function () {
        $output = $this->repository->create($this->responsible);

        expect($output)->toBeNull();
        $this->assertDatabaseHas('responsibles', [
            'uuid' => $this->responsible->getId()->value,
            'name' => $this->responsible->getName(),
            'created_at' => $this->responsible->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->responsible->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);
    });

    it('should throw exception on responsible saving error', function () {
        expect(function () {
            ResponsibleModel::saving(throw new \Exception('Error saving responsible.'));
            $this->repository->create($this->responsible);
        })->toThrow(new \Exception('Error saving responsible.'));

        $this->assertDatabaseMissing('responsibles', ['uuid' => $this->responsible->getId()->value]);
    });
});
