<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/database', function () {
    return [
        'users' => User::all(),
        'database' => [
            'driver' => config('database.default'),
            'name' => config('database.connections.'.config('database.default').'.database'),
        ],
    ];
})->name('database');

Route::get('/environment-variables', function () {
    return [
        'APP_ENV' => config('app.env'),
        'APP_DEBUG' => config('app.debug'),
        'TEST_TOKEN' => $_SERVER['TEST_TOKEN'] ?? false,
    ];
})->name('environment-variables');

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/test/{page}', function ($page) {
    return view('test-pages.'.$page);
})->name('test-page');
