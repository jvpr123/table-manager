<?php

namespace Tests\Feature;

use App\Models\Responsible;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

describe('ResponsibleController::store()', function () {
    beforeEach(fn () => $this->route = route('store-responsible'));

    it('should return 201 HTTP status-code with stored responsible', function () {
        $bodyData = Responsible::factory()->make()->toArray();

        $response = $this->postJson($this->route, $bodyData);
        $response->assertCreated();
        $response->assertSee('Responsible created successfully.');
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'responsible']));
    });

    it('should return 400 HTTP status-code with validation errors', function () {
        $bodyData = [];
        $response = $this->postJson($this->route, $bodyData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertSee('Validation error.');
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'errors']));
    });

    it('should return 500 HTTP status-code in case of generic error', function () {
        Responsible::saving(fn () => throw new \Exception('Database error.'));

        $bodyData = Responsible::factory()->make()->toArray();

        $response = $this->postJson($this->route, $bodyData);
        $response->assertInternalServerError();
        $response->assertSee('Database error.');
    });
});
