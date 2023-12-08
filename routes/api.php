<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\ExhibitionController;
use App\Http\Controllers\Api\ApiController;

Route::post("/signin", [AuthController::class, "signin"]);
Route::post("/signout", [AuthController::class, "signout"]);

// გამოფენების მარშუტები
Route::group(["prefix" => "exhibition", "middleware" => "auth:api"], function() {
    Route::get("/list", [ExhibitionController::class, "index"]); // გამოფენების სიის მარშუტი
    Route::get("/show/{id}", [ExhibitionController::class, "show"])->where(["id" => "[0-9]+"]); // გამოფენების სიის მარშუტი
    Route::delete("/delete/{id}", [ExhibitionController::class, "destroy"])->where(["id" => "[0-9]+"]); // გამოფენის წაშლის მარშუტი
    Route::post("/add", [ExhibitionController::class, "store"]); // გამოფენის დამატების მარშუტი
    Route::put("/update/{id}", [ExhibitionController::class, "update"])->where(["id" => "[0-9]+"]); // გამოფენის განახლების მარშუტი
});

Route::group(["prefix" => "detail"], function() {
    Route::post("/add/{id}", [ApiController::class, "addDetail"])->where(["id" => "[0-9]+"]);
    Route::get("/get/{id}", [ApiController::class, "getDetail"]);
});

?>