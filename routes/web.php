<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstructorController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware(['role:staff,admin'])->prefix('manage')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
        Route::get('/intructor', [InstructorController::class, 'index'])->name('intructor');
        Route::get('/intructor/form/{id?}', [InstructorController::class, 'formPage'])->name('intructor.form');
        Route::post('/intructor', [InstructorController::class, 'storeNewInstructor'])->name('intructor.post');
        Route::put('/intructor/{id}', [InstructorController::class, 'updateInstructor'])->name('intructor.update');
    });

    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::delete('/intructor/{id}', [InstructorController::class, 'destroyInstructor'])->middleware('role:admin')->name('intructor.delete');
    });

});

require __DIR__.'/auth.php';
