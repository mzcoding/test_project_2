<?php

declare(strict_types=1);

use App\Http\Controllers\V1\BookEventController;
use App\Http\Controllers\V1\EventItemController;
use App\Http\Controllers\V1\ShowController;
use App\Http\Controllers\V1\ShowItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/shows', ShowController::class);
    Route::get('/shows/{id}/events', ShowItemController::class)
        ->where('id', '\d+');
    Route::get('/events/{id}/places', EventItemController::class)
        ->where('id', '\d+');
    Route::post('/events/{id}/reserve', BookEventController::class)
        ->where('id', '\d+');
});
