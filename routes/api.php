<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\InviteController;

Route::group(["prefix" => "auth"], function () {
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);
});


Route::group(["prefix" => "user"], function () {
    Route::group(["middleware" => "auth:api"], function () {
        Route::get("profile", [AuthController::class, "profile"]);
        Route::get("logout", [AuthController::class, "logout"]);
        Route::get("/search/{query}", [UserController::class, "search"]);
    });
});

Route::group(["prefix" => "message"], function () {
    Route::group(["middleware" => "auth:api"], function () {
        Route::get("/{id}", [MessageController::class, "display"]);
        Route::post("/create", [MessageController::class, "store"]);
        Route::put("/update", [MessageController::class, "update"]);
        Route::delete("/delete", [MessageController::class, "delete"]);
    });
});

Route::group(["prefix" => "group"], function () {
    Route::group(["middleware" => "auth:api"], function () {
        Route::get("/{id}", [GroupController::class, "display"]);
        Route::get("/", [GroupController::class, "displayGroup"]);
        Route::get("{group_id}/messages", [GroupController::class, "getGroupMessages"]);
        Route::post("create", [GroupController::class, "create"]);
        Route::post("addUser", [GroupController::class, "addUser"]);
        Route::post("addMessage", [GroupController::class, "addMessage"]);
        Route::put("update/message/{message_id}", [GroupController::class, "updateMessage"]);
        Route::delete("delete/{group_id}", [GroupController::class, "deleteGroup"]);
        Route::delete("delete/{group_id}/message/{message_id}", [GroupController::class, "deleteMessage"]);
    });
});

Route::group(["prefix" => "meeting"], function () {
    Route::group(["middleware" => "auth:api"], function () {
        Route::post("schedule", [MeetingController::class, "scheduleMeeting"]);
    });
});

Route::group(["prefix" => "organization"], function () {
    Route::group(["middleware" => "auth:api"], function () {
        Route::post("create", [OrganizationController::class, "create"]);
        Route::put("update/{id}", [OrganizationController::class,"updateOrganization"]);
        Route::delete("delete/{id}", [OrganizationController::class, "deleteOrganization"]);  
        Route::get("/search/{id}", [OrganizationController::class, "getOrganization"]);  
    });
});

Route::group(["prefix" => "invite"], function () {
    Route::group(["middleware" => "auth:api"], function () {
        Route::post("create", [InviteController::class, "createToken"]);
    });
});

Route::get("invite/{userId}/verify/{token}", [InviteController::class, "verifyToken"]);
// http://teams-backend-laravel.test/api/invite/ef51ded6-40e5-4740-b02f-5c57fbd52cf4/verify/$2y$12$kJqu5DkxjhJnPNv3afZRfOfL1ooAvpmCNSjy7FDCr/PoeGtpjMzhq


// Route::get("/delete",[InviteController::class,"dropTable"]);

