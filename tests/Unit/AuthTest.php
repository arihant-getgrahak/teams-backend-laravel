<?php
use Illuminate\Database\Events\DatabaseRefreshed;
test('authTest', function () {
    // Login Test
    $response = $this->postJson('/api/en/auth/login', [
        'email' => "admin7@admin.com",
        'password' => '123456789',
    ]);

    if ($response->status() == 401) {
        dd($response->json('message'));
    } else {
        $response->assertStatus(200);
        $response->assertJson([
            'token' => $response->json('token'),
            'message' => $response->json('message'),
        ]);
    }


    // Register Test
    $response = $this->postJson('/api/en/auth/register', [
        'email' => "admin2@admin.com",
        'password' => '123456789',
        "name" => "Arihant Jain",
        "designation" => "Developer",
        "language" => "en",
    ]);

    if ($response->status() == 422) {
        dd($response->json('message'));
    } else {
        $response->assertStatus(200);

        $response->assertJson([
            'status' => $response->json('status'),
            'message' => $response->json('message'),
        ]);

    }
});

