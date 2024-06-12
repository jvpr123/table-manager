<?php

namespace App\Http\Controllers;

use App\Http\Requests\Local\CreateLocalRequest;
use Illuminate\Http\Response;
use Modules\Admin\DTO\Local\CreateLocalInputDTO;
use Modules\Admin\UseCase\Local\CreateLocalUseCase;

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
}
