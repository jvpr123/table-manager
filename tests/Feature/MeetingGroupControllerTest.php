<?php

namespace Tests\Feature;

use App\Models\MeetingGroup;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

describe('MeetingGroupController::store()', function () {
    beforeEach(fn () => $this->route = route('store-meeting-group'));

    it('should return 201 HTTP status-code with stored meeting group', function () {
        $bodyData = MeetingGroup::factory()->make()->toArray();

        $response = $this->postJson($this->route, $bodyData);
        info($bodyData);
        info(json_encode($response));
        $response->assertCreated();
        $response->assertSee('Meeting Group created successfully.');
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'meeting_group']));
    });

    it('should return 400 HTTP status-code with validation errors', function () {
        $bodyData = [];
        $response = $this->postJson($this->route, $bodyData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertSee('Validation error.');
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'errors']));
    });

    it('should return 500 HTTP status-code in case of generic error', function () {
        MeetingGroup::saving(fn () => throw new \Exception('Database error.'));

        $bodyData = MeetingGroup::factory()->make()->toArray();

        $response = $this->postJson($this->route, $bodyData);
        $response->assertInternalServerError();
        $response->assertSee('Database error.');
    });
});
