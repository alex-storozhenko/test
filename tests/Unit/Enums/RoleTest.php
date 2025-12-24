<?php

declare(strict_types=1);

use App\Enums\Role;

it('scopes agent role by office', function () {
    // Act & Assert
    expect(Role::AGENT->scopedByOffice())->toBeTrue();
})->group('enums', 'authorization');

it('does not scope god role by office', function () {
    // Act & Assert
    expect(Role::GOD->scopedByOffice())->toBeFalse();
})->group('enums', 'authorization');

it('does not scope admin role by office', function () {
    // Act & Assert
    expect(Role::ADMIN->scopedByOffice())->toBeFalse();
})->group('enums', 'authorization');

it('does not scope commercial director by office', function () {
    // Act & Assert
    expect(Role::COMMERCIAL_DIRECTOR->scopedByOffice())->toBeFalse();
})->group('enums', 'authorization');

it('returns boolean value', function () {
    // Arrange
    $roles = Role::cases();

    // Act & Assert: All roles should return boolean
    foreach ($roles as $role) {
        expect($role->scopedByOffice())->toBeBool();
    }
})->group('enums', 'authorization');
