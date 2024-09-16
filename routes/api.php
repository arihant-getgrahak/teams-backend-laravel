<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;


Route::group(["prefix" => "auth"], function () {
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);
});

Route::group([
    "middleware" => ["auth:api"]
], function () {

});

Route::group(["prefix" => "/user"], function () {
    Route::get("profile", [AuthController::class, "profile"]);
    Route::get("logout", [AuthController::class, "logout"]);
})->middleware("auth:api");

Route::group(["prefix" => "message"], function () {
    Route::get("/", [MessageController::class, "display"]);
    Route::post("/create", [MessageController::class, "store"]);
    Route::post("/update", [MessageController::class, "update"]);
    Route::delete("/delete", [MessageController::class, "delete"]);
})->middleware("auth:api");

Route::get("/search/{id}", [UserController::class, "search"]);
