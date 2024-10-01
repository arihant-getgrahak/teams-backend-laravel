<?php
use Illuminate\Database\Events\DatabaseRefreshed;
test('authTest', function () {
    // Login Test
    $response = $this->postJson('/api/en/auth/login', [
        'email' => "admin6@admin.com",
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
});

