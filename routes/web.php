<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [
    DashboardController::class, 'index'
])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/tasks', [
    TasksController::class, 'createTask'
])->middleware('auth')->name('tasks.create');

Route::get('/tasks/{id}/complete', [
    TasksController::class, 'markComplete'
])->middleware('admin')->name('tasks.complete');

Route::get('/preview-file', function (\Illuminate\Http\Request $request) {
    $path = $request->get('path');

    return \Illuminate\Support\Facades\Storage::download($path);
})->middleware('admin')->name('download.file');


Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

require __DIR__ . '/auth.php';
