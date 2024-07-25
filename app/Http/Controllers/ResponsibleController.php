<?php

namespace App\Http\Controllers;

use App\Http\Requests\Responsible\CreateResponsibleRequest;
use Illuminate\Http\Response;
use Modules\Admin\DTO\Responsible\CreateResponsibleInputDTO;
use Modules\Admin\UseCase\Responsible\CreateResponsibleUseCase;
use Modules\Admin\UseCase\Responsible\ListResponsiblesUseCase;

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
}
