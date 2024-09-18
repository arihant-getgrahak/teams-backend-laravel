<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MeetingController;

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
        Route::post("create", [GroupController::class, "create"]);
        Route::post("addUser", [GroupController::class, "addUser"]);
        Route::post("addMessage", [GroupController::class, "addMessage"]);
        Route::get("/{group_id}/messages", [GroupController::class, "getGroupMessages"]);
        Route::delete("delete/{group_id}", [GroupController::class, "deleteGroup"]);
    });
});

Route::group(["prefix"=> "meeting"], function () {
    Route::group(["middleware"=> "auth:api"], function () {
        Route::post("schedule", [MeetingController::class, "scheduleMeeting"]);
    });
});
