<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\API\V1\GameController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\AdminController;
use App\Http\Controllers\API\V1\Auth\SignInController;
use App\Http\Controllers\API\V1\Auth\SignUpController;
use App\Http\Controllers\API\V1\Auth\SignOutController;

Route::prefix('v1')->name('v1.')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('signin', SignInController::class)->name('signin');
        Route::post('signup', SignUpController::class)->name('signup');
    });
});

Route::middleware('auth:sanctum')->prefix('v1')->name('v1.')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('signout', SignOutController::class)->name('signout');
    });

    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('', [AdminController::class, 'index'])->name('index');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
    });

    Route::prefix('games')->name('games.')->group(function () {
        Route::get('', [GameController::class, 'index'])->name('index');
        Route::post('', [GameController::class, 'store'])->name('store');
        Route::get('{slug}', [GameController::class, 'show'])->name('show');
        Route::post('{slug}/upload', [GameController::class, 'upload'])->name('upload');
    });
});


Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::post('/upload', [FileUploadController::class, 'upload']);
