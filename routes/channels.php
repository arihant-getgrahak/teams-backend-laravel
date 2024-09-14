<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('teams-chat-channel.{userId}', function (User $user, $userId) {
    dd($userId);
    // return true;
});