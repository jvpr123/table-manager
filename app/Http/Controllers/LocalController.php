<?php

namespace App\Http\Controllers;

use App\Http\Requests\Local\CreateLocalRequest;
use App\Http\Requests\Local\UpdateLocalRequest;
use Illuminate\Http\Response;
use Modules\Admin\DTO\Local\CreateLocalInputDTO;
use Modules\Admin\DTO\Local\UpdateLocalInputDTO;
use Modules\Admin\UseCase\Local\CreateLocalUseCase;
use Modules\Admin\UseCase\Local\DeleteLocalUseCase;
use Modules\Admin\UseCase\Local\FindLocalByIdUseCase;
use Modules\Admin\UseCase\Local\ListLocalsUseCase;
use Modules\Admin\UseCase\Local\UpdateLocalUseCase;

class LocalController extends Controller
{
    public function store(
        CreateLocalUseCase $useCase,
        CreateLocalRequest $request
    ) {
        $input = new CreateLocalInputDTO(
            title: $request->validated('title'),
            description: $request->validated('description'),
        );

        $local = $useCase->execute($input);

        return response()->json([
            'message' => 'Local created successfully.',
            'local' => $local,
        ], Response::HTTP_CREATED);
    }

    public function show(FindLocalByIdUseCase $useCase, string $localId)
    {
        $local = $useCase->execute($localId);

        return response()->json([
            'message' => 'Local found successfully.',
            'local' => $local,
        ]);
    }

    public function index(ListLocalsUseCase $useCase)
    {
        $locals = $useCase->execute();

        return response()->json([
            'message' => 'Locals found successfully.',
            'locals' => $locals,
        ]);
    }

    public function update(
        UpdateLocalUseCase $useCase,
        UpdateLocalRequest $request,
        string $localId
    ) {
        $dto = new UpdateLocalInputDTO(
            id: $localId,
            title: $request->validated('title'),
            description: $request->validated('description'),
        );

        $updatedLocal = $useCase->execute($dto);

        return response()->json([
            'message' => 'Local updated successfully.',
            'local' => $updatedLocal,
        ]);
    }

    public function delete(DeleteLocalUseCase $useCase, string $localId)
    {
        $useCase->execute($localId);
        return response()->json([
            'message' => 'Local deleted successfully.',
        ]);
    }
}
