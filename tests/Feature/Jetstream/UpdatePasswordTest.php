<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

test('password can be updated', function () {
    $this->actingAs($user = User::factory()->create());

    $password = Str::password();

    $this->put('/user/password', [
        'current_password' => 'Password123!',
        'password' => $password,
        'password_confirmation' => $password,
    ]);

    expect(Hash::check($password, $user->fresh()->password))->toBeTrue();
});

test('current password must be correct', function () {
    $this->actingAs($user = User::factory()->create());

    $response = $this->put('/user/password', [
        'current_password' => 'wrong-password',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check('Password123!', $user->fresh()->password))->toBeTrue();
});

test('new passwords must match', function () {
    $this->actingAs($user = User::factory()->create());

    $response = $this->put('/user/password', [
        'current_password' => 'password',
        'password' => 'new-password',
        'password_confirmation' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check('Password123!', $user->fresh()->password))->toBeTrue();
});
