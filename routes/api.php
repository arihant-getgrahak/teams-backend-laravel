<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\MessageController;


Route::group(["prefix" => "auth"], function () {
    Route::post("register", [ApiController::class, "register"]);
    Route::post("login", [ApiController::class, "login"]);
});

Route::group([
    "middleware" => ["auth:api"]
], function () {

});

Route::group(["prefix" => "/user"], function () {
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("logout", [ApiController::class, "logout"]);
})->middleware("auth:api");

Route::group(["prefix" => "message"], function () {
    Route::get("/", [MessageController::class, "display"]);
    Route::post("/create", [MessageController::class, "store"]);
    Route::post("/create", [MessageController::class, "store"]);
    Route::delete("/delete", [MessageController::class, "delete"]);
})->middleware("auth:api");
