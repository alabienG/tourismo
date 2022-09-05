<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTY2MjM2NjMzOSwiZXhwIjoxNjYyMzY5OTM5LCJuYmYiOjE2NjIzNjYzMzksImp0aSI6Im5KdE15TXBEMlIwUXVGQTMiLCJzdWIiOjIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.ZcLrbqy7axDjzAjgn03bSDPYa8w4-5C06r1oYxjzLcA

*/

Route::group(['middleware' => ['jwt.verify']], function () {

    Route::get("dicos", [\App\Http\Controllers\DictionnaireController::class, "index"]);
    Route::post("dicos", [\App\Http\Controllers\DictionnaireController::class, "store"]);
    Route::put("dicos/{id}", [\App\Http\Controllers\DictionnaireController::class, "update"]);
    Route::get("dicos/childrens/{id}", [\App\Http\Controllers\DictionnaireController::class, "getAllChildrens"]);
    Route::delete("dicos/{id}", [\App\Http\Controllers\DictionnaireController::class, "destroy"]);

    Route::delete("lieux/{id}", [\App\Http\Controllers\LieuController::class, "destroy"]);
    Route::post("lieux", [\App\Http\Controllers\LieuController::class, 'store']);
    Route::put("lieux/{id}", [\App\Http\Controllers\LieuController::class, 'update']);
    Route::post("lieux/{idLieu}", [\App\Http\Controllers\LieuController::class, "likes"]);
    Route::post("lieux/dislike/{idLieu}", [\App\Http\Controllers\LieuController::class, "dislikes"]);

    // image lieu

});



// lieux
Route::post("images/{idLieu}", [\App\Http\Controllers\ImageController::class, 'store']);
Route::get("lieux", [\App\Http\Controllers\LieuController::class, "index"]);
Route::get("lieux/{id}", [\App\Http\Controllers\LieuController::class, "show"]);
Route::get("lieux/dico/{idDico}", [\App\Http\Controllers\LieuController::class, "lieuxByDico"]);




// auth
Route::post("login", [\App\Http\Controllers\LoginController::class, 'login']);
Route::post("register", [\App\Http\Controllers\LoginController::class, 'register']);
