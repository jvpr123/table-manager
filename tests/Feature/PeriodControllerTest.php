<?php

namespace Tests\Feature;

use App\Models\Period;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;

describe('PeriodController::store()', function () {
    beforeEach(fn () => $this->route = route('store-period'));

    it('should return 201 HTTP status-code with stored peroid', function () {
        $bodyData = Period::factory()->make()->toArray();

        $response = $this->postJson($this->route, $bodyData);
        $response->assertCreated();
        $response->assertSee('Period created successfully.');
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'period']));
    });

    it('should return 400 HTTP status-code with validation errors', function () {
        $bodyData = ['time' => null];

        $response = $this->postJson($this->route, $bodyData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertSee('Validation error.');
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'errors']));
    });

    it('should return 500 HTTP status-code in case of generic error', function () {
        Period::saving(fn () => throw new \Exception('Database error.'));

        $bodyData = Period::factory()->make()->toArray();

        $response = $this->postJson($this->route, $bodyData);
        $response->assertInternalServerError();
        $response->assertSee('Database error.');
    });
});
