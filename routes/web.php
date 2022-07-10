<?php

use App\Http\Controllers\TopicController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('/topics')->group(function() {
        Route::get('/', [TopicController::class, 'index'])->name('topics.index');
        Route::post('/', [TopicController::class, 'store'])->name('topics.store');
        Route::get('/create', [TopicController::class, 'create'])->name('topics.create');
        Route::put('/{topic}', [TopicController::class, 'update'])->name('topics.update');
        Route::delete('/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');
        Route::get('/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
    });
});



