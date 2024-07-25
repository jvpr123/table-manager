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

describe('ResponsibleController::index()', function () {
    it('should return 200 HTTP status-code with found locals', function () {
        $responsibles = Responsible::factory()->count(5)->create();
        $route = route('get-responsibles');

        $response = $this->getJson($route);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Responsibles found successfully.');
        expect($responseData['responsibles'])->toHaveCount($responsibles->count());
    });

    it('should return 200 HTTP status-code with empty array if no responsible found', function () {
        $route = route('get-responsibles');
        $response = $this->getJson($route);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Responsibles found successfully.');
        expect($responseData['responsibles'])->toBeEmpty();
    });
});

describe('ResponsibleController::show()', function () {
    it('should return 200 HTTP status-code with found responsible', function () {
        $responsible = Responsible::factory()->create();
        $route = route('get-responsible', ['responsibleId' => $responsible->uuid]);

        $response = $this->getJson($route);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Responsible found successfully.');
        expect($responseData['responsible']->id)->toBe($responsible->uuid);
    });

    it('should return 404 HTTP status-code if responsible not found', function () {
        $route = route('get-responsible', ['responsibleId' => $id = uuid_create()]);

        $response = $this->getJson($route);
        $response->assertNotFound();
        $response->assertSee("Responsible not found using ID $id provided.");
    });
});
