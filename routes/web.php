<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['webRedirect'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/{any}', function (string $anys) {
        return view('welcome');
    });
});
