<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;


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
    Route::post("/create", [MessageController::class, "store"]);
    Route::delete("/delete", [MessageController::class, "delete"]);
})->middleware("auth:api");
