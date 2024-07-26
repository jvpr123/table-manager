<?php

namespace App\Http\Controllers;

use App\Http\Requests\Period\CreatePeriodRequest;
use Illuminate\Http\Response;
use Modules\Admin\DTO\Period\CreatePeriodInputDTO;
use Modules\Admin\UseCase\Period\CreatePeriodUseCase;

class PeriodController extends Controller
{
    public function store(
        CreatePeriodUseCase $useCase,
        CreatePeriodRequest $request
    ) {
        $input = new CreatePeriodInputDTO(time: $request->validated('time'));
        $period = $useCase->execute($input);

        return response()->json([
            'message' => 'Period created successfully.',
            'period' => $period,
        ], Response::HTTP_CREATED);
    }
}
