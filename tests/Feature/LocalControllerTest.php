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
        $response->assertCreated();
        $response->assertSee('Local created successfully.');
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'local']));
    });

    it('should return 400 HTTP status-code with validation errors', function () {
        $bodyData = [
            'title' => null,
            'description' => 50,
        ];

        $response = $this->postJson($this->route, $bodyData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertSee('Validation error.');
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'errors']));
    });

    it('should return 500 HTTP status-code in case of generic error', function () {
        Local::saving(fn () => throw new \Exception('Database error.'));

        $bodyData = Local::factory()->make()->toArray();

        $response = $this->postJson($this->route, $bodyData);
        $response->assertInternalServerError();
        $response->assertSee('Database error.');
    });
});

describe('LocalController::show()', function () {
    it('should return 200 HTTP status-code with found local', function () {
        $local = Local::factory()->create();
        $route = route('get-local', ['localId' => $local->uuid]);

        $response = $this->getJson($route);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Local found successfully.');
        expect($responseData['local']->id)->toBe($local->uuid);
    });

    it('should return 404 HTTP status-code if local not found', function () {
        $route = route('get-local', ['localId' => $id = uuid_create()]);

        $response = $this->getJson($route);
        $response->assertNotFound();
        $response->assertSee("Local not found using ID $id provided.");
    });
});

describe('LocalController::index()', function () {
    it('should return 200 HTTP status-code with found locals', function () {
        $locals = Local::factory()->count(5)->create();
        $route = route('get-locals');

        $response = $this->getJson($route);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Locals found successfully.');
        expect($responseData['locals'])->toHaveCount($locals->count());
    });

    it('should return 200 HTTP status-code with empty array if no local found', function () {
        $route = route('get-locals');
        $response = $this->getJson($route);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Locals found successfully.');
        expect($responseData['locals'])->toBeEmpty();
    });
});

describe('LocalController::update()', function () {
    beforeEach(function () {
        $this->local = Local::factory()->create();
        $this->route = route('update-local', ['localId' => $this->local->uuid]);
    });

    it('should return 200 HTTP status-code with updated local', function () {
        $bodyData = Local::factory()->make()->toArray();

        $response = $this->putJson($this->route, $bodyData);
        $response->assertOk();

        $responseData = $response->getOriginalContent();
        expect($responseData['message'])->toBe('Local updated successfully.');
        expect($responseData['local']->id)->toBe($this->local->uuid);
        expect($responseData['local']->title)->toBe($bodyData['title']);
        expect($responseData['local']->description)->toBe($bodyData['description']);
    });

    it('should return 400 HTTP status-code with validation errors', function () {
        $bodyData = [
            'title' => null,
            'description' => 50,
        ];

        $response = $this->putJson($this->route, $bodyData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertSee('Validation error.');
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['message', 'errors']));
    });

    it('should return 404 HTTP status-code if local not found', function () {
        $route = route('update-local', $id = uuid_create());
        $bodyData = Local::factory()->make()->toArray();

        $response = $this->putJson($route, $bodyData);
        $response->assertNotFound();
        $response->assertSee("Local not found using ID $id provided.");
    });
});

describe('LocalController::delete()', function () {
    beforeEach(function () {
        $this->local = Local::factory()->create();
        $this->route = route('delete-local', ['localId' => $this->local->uuid]);
    });

    it('should return 200 HTTP status-code if local deleted', function () {
        $response = $this->deleteJson($this->route);
        $response->assertOk();
        $response->assertSee('Local deleted successfully.');
    });

    it('should return 404 HTTP status-code if local not found', function () {
        $route = route('delete-local', $id = uuid_create());

        $response = $this->deleteJson($route);
        $response->assertNotFound();
        $response->assertSee("Local not found using ID $id provided.");
    });
});
