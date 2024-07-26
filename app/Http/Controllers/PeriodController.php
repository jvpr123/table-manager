<?php

namespace App\Http\Controllers;

use App\Http\Requests\Period\CreatePeriodRequest;
use Illuminate\Http\Response;
use Modules\Admin\DTO\Period\CreatePeriodInputDTO;
use Modules\Admin\UseCase\Period\CreatePeriodUseCase;
use Modules\Admin\UseCase\Period\FindPeriodByIdUseCase;
use Modules\Admin\UseCase\Period\ListPeriodsUseCase;

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

    public function index(ListPeriodsUseCase $useCase)
    {
        $periods = $useCase->execute();

        return response()->json([
            'message' => 'Periods found successfully.',
            'periods' => $periods,
        ]);
    }

    public function show(FindPeriodByIdUseCase $useCase, string $periodId)
    {
        $period = $useCase->execute($periodId);

        return response()->json([
            'message' => 'Period found successfully.',
            'period' => $period,
        ]);
    }
}
