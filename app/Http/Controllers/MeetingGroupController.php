<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingGroup\CreateMeetingGroupRequest;
use Illuminate\Http\Response;
use Modules\Admin\DTO\MeetingGroup\CreateMeetingGroupInputDTO;
use Modules\Admin\UseCase\MeetingGroup\CreateMeetingGroupUseCase;

class MeetingGroupController extends Controller
{
    public function store(
        CreateMeetingGroupUseCase $useCase,
        CreateMeetingGroupRequest $request
    ) {
        $input = new CreateMeetingGroupInputDTO(
            name: $request->validated('name'),
            description: $request->validated('description'),
        );

        $meetingGroup = $useCase->execute($input);

        return response()->json([
            'message' => 'Meeting Group created successfully.',
            'meeting_group' => $meetingGroup,
        ], Response::HTTP_CREATED);
    }
}
