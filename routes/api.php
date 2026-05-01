<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController;
use App\Http\Controllers\Api\CommandController;

// SENSOR
Route::post('/sensor', [SensorController::class, 'store']);
Route::get('/sensor/latest', [SensorController::class, 'latest']);

// COMMAND
Route::post('/command', [CommandController::class, 'store']);
Route::get('/command/{device_id}', [CommandController::class, 'getCommand']);

Route::get('/debug-db', function () {
    return [
        'db' => DB::connection()->getDatabaseName(),
        'tables' => DB::select('SHOW TABLES')
    ];
});