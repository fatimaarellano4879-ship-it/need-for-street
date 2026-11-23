<?php

use App\Http\Controllers\NeedForStreetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NeedForStreetController::class, 'index']);

Route::prefix('nfs')->group(function () {
    // Endpoints públicos limitados al acceso inicial.
    Route::get('/login-users', [NeedForStreetController::class, 'loginUsers'])
        ->middleware('throttle:30,1');

    Route::post('/login', [NeedForStreetController::class, 'login'])
        ->middleware('throttle:5,1');

    Route::get('/session', [NeedForStreetController::class, 'sessionStatus']);

    // Todas las operaciones de datos requieren una sesión Laravel válida.
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [NeedForStreetController::class, 'logout']);
        Route::get('/bootstrap', [NeedForStreetController::class, 'bootstrap']);
        Route::post('/sync', [NeedForStreetController::class, 'sync']);
        Route::get('/qr/{code}', [NeedForStreetController::class, 'qr'])
            ->where('code', '[A-Za-z0-9_-]{3,40}')
            ->middleware('throttle:120,1');
    });
});
