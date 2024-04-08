<?php

namespace Tests\Unit\Modules\Shared\Validation;

use Modules\Shared\Exceptions\UndefinedEntityProperty;
use Modules\Shared\Validation\SelfValidation;

describe('SelfValidation field register unit tests', function () {
    beforeEach(function () {
        $this->trait = new class
        {
            use SelfValidation;
            public string $name;
        };
    });

    it('should register a field into array of errors if field exists successfully', function () {
        $output = $this->executePrivateMethod($this->trait, 'pushField', ['name']);
        expect($output)->toBe($this->trait);
        expect($this->getPrivateProperty($this->trait, 'errors'))->toHaveKey('name');
    });

    it('should throw exception if field provided doesn`t exist', function () {
        expect(fn () => $this->executePrivateMethod($this->trait, 'pushField', ['invalid_field']))
            ->toThrow(new UndefinedEntityProperty($this->trait::class, 'invalid_field'));
    });
});

describe('SelfValidation error register unit tests', function () {
    beforeEach(function () {

        $this->trait = new class
        {
            use SelfValidation;
            public string $name;
        };
    });

    it('should register a field before pushing errors into it successfully', function () {
        $output = $this->executePrivateMethod(
            $this->trait,
            'pushError',
            ['name', 'Field name is required.']
        );

        $errors = $this->getPrivateProperty($this->trait, 'errors');
        expect($output)->toBe($this->trait);
        expect($errors)->toHaveKey('name');
        expect($errors['name'])->toHaveCount(1);
        expect($errors['name'][0])->toBe('Field name is required.');
    });

    it('should push error if field is already registered successfully', function () {
        $this->executePrivateMethod($this->trait, 'pushField', ['name']);
        $this->executePrivateMethod($this->trait, 'pushError', ['name', 'Field name is required.']);

        $output = $this->executePrivateMethod(
            $this->trait,
            'pushError',
            ['name', 'Field name must have at least 3 characters.']
        );

        $errors = $this->getPrivateProperty($this->trait, 'errors');
        expect($output)->toBe($this->trait);
        expect($errors)->toHaveKey('name');
        expect($errors['name'])->toHaveCount(2);
        expect($errors['name'][0])->toBe('Field name is required.');
        expect($errors['name'][1])->toBe('Field name must have at least 3 characters.');
    });

    it('should throw exception if field provided doesn`t exist', function () {
        expect(fn () => $this->executePrivateMethod(
            $this->trait,
            'pushError',
            ['invalid_field', 'Error on invalid field.']
        ))->toThrow(new UndefinedEntityProperty($this->trait::class, 'invalid_field'));
    });
});
