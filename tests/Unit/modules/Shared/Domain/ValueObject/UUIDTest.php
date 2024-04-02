<?php

namespace Tests\Unit\Modules\Shared\Domain\ValueObject;

use Modules\Shared\Domain\Exceptions\InvalidUuidException;
use Modules\Shared\Domain\ValueObject\UUID;

describe('UUID validation unit tests', function () {
    it('should return true if validation succeeds', function () {
        $output = UUID::validate(uuid_create());
        expect($output)->toBeTrue();
    });

    it('should return false if validation fails', function () {
        $output = UUID::validate('');
        expect($output)->toBeFalse();
    });
});

describe('UUID generation unit tests', function () {
    it('should create a new UUID when no id is provided in constructor successfully', function () {
        $output = new UUID();
        expect($output->value)->toBeString();
    });

    it('should create a new UUID based on id provided in constructor successfully', function () {
        $output = new UUID($uuid = uuid_create());
        expect($output->value)->toBe($uuid);
    });

    it(
        'should throw exception if invalid UUID is provided in constructor',
        fn () => new UUID('invalid_uuid')
    )->throws(InvalidUuidException::class, 'Invalid UUID value provided.');
});
