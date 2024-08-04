<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PdfController;

Route::get('/', function () {
    return json_encode([
        'PHP' => phpversion(),
        'FRAMEWORK' => 'LARAVEL ' . app()->version()
    ]);
})->name('api.fallback');

Route::get('/pdf', [PdfController::class, 'process']);