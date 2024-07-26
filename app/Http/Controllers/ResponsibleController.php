<?php

namespace App\Http\Controllers;

use App\Http\Requests\Responsible\CreateResponsibleRequest;
use Illuminate\Http\Response;
use Modules\Admin\DTO\Responsible\CreateResponsibleInputDTO;
use Modules\Admin\DTO\Responsible\UpdateResponsibleInputDTO;
use Modules\Admin\UseCase\Responsible\CreateResponsibleUseCase;
use Modules\Admin\UseCase\Responsible\DeleteResponsibleUseCase;
use Modules\Admin\UseCase\Responsible\FindResponsibleByIdUseCase;
use Modules\Admin\UseCase\Responsible\ListResponsiblesUseCase;
use Modules\Admin\UseCase\Responsible\UpdateResponsibleUseCase;

class ResponsibleController extends Controller
{
    public function store(
        CreateResponsibleUseCase $useCase,
        CreateResponsibleRequest $request
    ) {
        $input = new CreateResponsibleInputDTO(
            name: $request->validated('name'),
        );

        $responsible = $useCase->execute($input);

        return response()->json([
            'message' => 'Responsible created successfully.',
            'responsible' => $responsible,
        ], Response::HTTP_CREATED);
    }

    public function index(ListResponsiblesUseCase $useCase)
    {
        $responsibles = $useCase->execute();

        return response()->json([
            'message' => 'Responsibles found successfully.',
            'responsibles' => $responsibles,
        ], Response::HTTP_OK);
    }

    public function show(
        FindResponsibleByIdUseCase $useCase,
        string $responsibleId
    ) {
        $responsible = $useCase->execute($responsibleId);

        return response()->json([
            'message' => 'Responsible found successfully.',
            'responsible' => $responsible,
        ], Response::HTTP_OK);
    }

    public function update(
        UpdateResponsibleUseCase $useCase,
        CreateResponsibleRequest $request,
        string $responsibleId
    ) {
        $input = new UpdateResponsibleInputDTO(
            id: $responsibleId,
            name: $request->validated('name'),
        );

        $updatedResponsible = $useCase->execute($input);

        return response()->json([
            'message' => 'Responsible updated successfully.',
            'responsible' => $updatedResponsible,
        ]);
    }

    public function delete(
        DeleteResponsibleUseCase $useCase,
        string $responsibleId
    ) {
        $useCase->execute($responsibleId);
        return response()->json([
            'message' => 'Responsible deleted successfully.',
        ]);
    }
}
