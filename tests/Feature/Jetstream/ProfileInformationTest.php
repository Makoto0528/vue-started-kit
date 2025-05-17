<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

test('profile information can be updated', function () {
    $this->actingAs($user = User::factory()->create());

    $this->put('/user/profile-information', [
        'name' => 'Test Name',
        'email' => 'test@example.com',
    ]);

    expect($user->fresh())
        ->name->toEqual('Test Name')
        ->email->toEqual('test@example.com');
});

test('profile photo can be updated', function () {
    \Illuminate\Support\Facades\Storage::fake();

    $this->actingAs($user = User::factory()->create());

    $this->put('/user/profile-information', [
        'name' => 'Test Name',
        'email' => $user->email,
        'photo' => UploadedFile::fake()->image('photo.jpg'),
    ]);

    expect($user->fresh())
        ->email->toEqual($user->email)
        ->profile_photo_path->not()->toBeNull();
});
