<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/query', [\App\Http\Controllers\Api\QueryController::class, 'processQuery']);
