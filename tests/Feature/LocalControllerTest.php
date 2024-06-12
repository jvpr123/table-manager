<?php

namespace Tests\Feature;

use App\Models\Local;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

describe('LocalController::store()', function () {
    beforeEach(fn () => $this->route = route('store-local'));

    it('should return 201 HTTP status-code with stored local', function () {
        $bodyData = Local::factory()->make()->toArray();

        $response = $this->postJson($this->route, $bodyData);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'local']));
    });

    it('should return 422 HTTP status-code with validation errors', function () {
        $bodyData = [
            'title' => null,
            'description' => 50,
        ];

        $response = $this->postJson($this->route, $bodyData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'errors']));
    });

    it('should return 500 HTTP status-code in case of generic error', function () {
        Local::saving(fn () => throw new \Exception());

        $bodyData = Local::factory()->make()->toArray();

        $response = $this->postJson($this->route, $bodyData);
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message']));
    });
});
