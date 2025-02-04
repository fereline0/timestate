<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SickLeaveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkingTimeController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [WorkingTimeController::class, 'home'])->name('home');

    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::prefix('working-times')->group(function () {
        Route::post('start', [WorkingTimeController::class, 'workStarted'])->name('working-times.start');
        Route::post('end', [WorkingTimeController::class, 'workEnded'])->name('working-times.end');
    });

    Route::prefix('dashboard')->middleware('role:Admin')->group(function () {
        Route::prefix('working-times')->group(function () {
            Route::get('', [WorkingTimeController::class, 'index'])->name('dashboard.working-times.index');
            Route::get('create', [WorkingTimeController::class, 'create'])->name('dashboard.working-times.create');
            Route::post('', [WorkingTimeController::class, 'store'])->name('dashboard.working-times.store');
            Route::prefix('{id}')->group(function () {
                Route::get('edit', [WorkingTimeController::class, 'edit'])->name('dashboard.working-times.edit');
                Route::put('', [WorkingTimeController::class, 'update'])->name('dashboard.working-times.update');
                Route::delete('', [WorkingTimeController::class, 'destroy'])->name('dashboard.working-times.destroy');
            });
        });

        Route::prefix('sick-leaves')->group(function () {
            Route::get('', [SickLeaveController::class, 'index'])->name('dashboard.sick-leaves.index');
            Route::get('create', [SickLeaveController::class, 'create'])->name('dashboard.sick-leaves.create');
            Route::post('', [SickLeaveController::class, 'store'])->name('dashboard.sick-leaves.store');
            Route::prefix('{id}')->group(function () {
                Route::get('edit', [SickLeaveController::class, 'edit'])->name('dashboard.sick-leaves.edit');
                Route::put('', [SickLeaveController::class, 'update'])->name('dashboard.sick-leaves.update');
                Route::delete('', [SickLeaveController::class, 'destroy'])->name('dashboard.sick-leaves.destroy');
            });
        });

        Route::prefix('vacations')->group(function () {
            Route::get('', [VacationController::class, 'index'])->name('dashboard.vacations.index');
            Route::get('create', [VacationController::class, 'create'])->name('dashboard.vacations.create');
            Route::post('', [VacationController::class, 'store'])->name('dashboard.vacations.store');
            Route::prefix('{id}')->group(function () {
                Route::get('edit', [VacationController::class, 'edit'])->name('dashboard.vacations.edit');
                Route::put('', [VacationController::class, 'update'])->name('dashboard.vacations.update');
                Route::delete('', [VacationController::class, 'destroy'])->name('dashboard.vacations.destroy');
            });
        });

        Route::prefix('users')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('dashboard.users.index');
            Route::prefix('{id}')->group(function () {
                Route::delete('', [UserController::class, 'destroy'])->name('dashboard.users.destroy');
            });
        });

        Route::prefix('departments')->group(function () {
            Route::get('', [DepartmentController::class, 'index'])->name('dashboard.departments.index');
            Route::get('create', [DepartmentController::class, 'create'])->name('dashboard.departments.create');
            Route::post('', [DepartmentController::class, 'store'])->name('dashboard.departments.store');
            Route::prefix('{id}')->group(function () {
                Route::get('edit', [DepartmentController::class, 'edit'])->name('dashboard.departments.edit');
                Route::put('', [DepartmentController::class, 'update'])->name('dashboard.departments.update');
                Route::delete('', [DepartmentController::class, 'destroy'])->name('dashboard.departments.destroy');
            });
        });
    });
});

require __DIR__ . '/auth.php';
