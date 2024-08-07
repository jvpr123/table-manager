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

describe('PeriodController::index()', function () {
    it('should return 200 HTTP status-code with found periods', function () {
        $periods = Period::factory()->count(5)->create();
        $route = route('get-periods');

        $response = $this->getJson($route);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Periods found successfully.');
        expect($responseData['periods'])->toHaveCount($periods->count());
    });

    it('should return 200 HTTP status-code with empty array if no period found', function () {
        $route = route('get-periods');
        $response = $this->getJson($route);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Periods found successfully.');
        expect($responseData['periods'])->toBeEmpty();
    });
});

describe('PeriodController::show()', function () {
    it('should return 200 HTTP status-code with found period', function () {
        $period = Period::factory()->create();
        $route = route('get-period', ['periodId' => $period->uuid]);

        $response = $this->getJson($route);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Period found successfully.');
        expect($responseData['period']->id)->toBe($period->uuid);
    });

    it('should return 404 HTTP status-code if period not found', function () {
        $route = route('get-period', ['periodId' => $id = uuid_create()]);

        $response = $this->getJson($route);
        $response->assertNotFound();
        $response->assertSee("Period not found using ID $id provided.");
    });
});

describe('PeriodController::update()', function () {
    beforeEach(function () {
        $this->period = Period::factory()->create();
        $this->route = route('update-period', ['periodId' => $this->period->uuid]);
    });

    it('should return 200 HTTP status-code with updated period', function () {
        $bodyData = Period::factory()->make()->toArray();

        $response = $this->putJson($this->route, $bodyData);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Period updated successfully.');
        expect($responseData['period']->id)->toBe($this->period->uuid);
        expect($responseData['period']->time)->toBe($bodyData['time']);
    });

    it('should return 400 HTTP status-code with validation errors', function () {
        $bodyData = ['time' => null];

        $response = $this->putJson($this->route, $bodyData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertSee('Validation error.');
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'errors']));
    });

    it('should return 404 HTTP status-code if period not found', function () {
        $route = route('update-period', $id = uuid_create());
        $bodyData = Period::factory()->make()->toArray();

        $response = $this->putJson($route, $bodyData);
        $response->assertNotFound();
        $response->assertSee("Period not found using ID $id provided.");
    });
});

describe('PeriodController::delete()', function () {
    beforeEach(function () {
        $this->period = Period::factory()->create();
        $this->route = route('delete-period', ['periodId' => $this->period->uuid]);
    });

    it('should return 200 HTTP status-code if period deleted', function () {
        $response = $this->deleteJson($this->route);
        $response->assertOk();
        $response->assertSee('Period deleted successfully.');
    });

    it('should return 404 HTTP status-code if period not found', function () {
        $route = route('delete-period', $id = uuid_create());

        $response = $this->deleteJson($route);
        $response->assertNotFound();
        $response->assertSee("Period not found using ID $id provided.");
    });
});
