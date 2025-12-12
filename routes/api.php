<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'projects'], function () {
  Route::get('/', [ProjectController::class, 'indexProjects']);
  Route::post('/', [ProjectController::class, 'storeProject']);
  Route::get('/{id}', [ProjectController::class, 'showProject']);
});

Route::group(['prefix' => 'tasks'], function () {
  Route::post('/', [TaskController::class, 'storeTask']);
  Route::patch('/{task}/toggle', [TaskController::class, 'toggleTask']);
  Route::delete('/{task}', [TaskController::class, 'destroyTask']);
});

Route::get('/difficulties', [TaskController::class, 'indexDifficulties']);