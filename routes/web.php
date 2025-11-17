<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('admin.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// AdminLTE demo routes
use App\Http\Controllers\AdminLteDemoController;

Route::prefix('adminlte')->group(function () {
    Route::get('/', [AdminLteDemoController::class, 'index'])->name('adminlte.index');
    Route::get('/login', [AdminLteDemoController::class, 'login'])->name('adminlte.login');
    Route::get('/register', [AdminLteDemoController::class, 'register'])->name('adminlte.register');
});

// Admin project pages (blade)
use App\Http\Controllers\Admin\ProjectAdminController;
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/projects', [ProjectAdminController::class,'index'])->name('admin.projects.index');
    Route::get('/projects/create', [ProjectAdminController::class,'create'])->name('admin.projects.create');
    Route::post('/projects', [ProjectAdminController::class,'store'])->name('admin.projects.store');
    Route::get('/projects/{project}', [ProjectAdminController::class,'show'])->name('admin.projects.show')->middleware('project');
    Route::get('/projects/{project}/edit', [ProjectAdminController::class,'edit'])->name('admin.projects.edit')->middleware('project');
    Route::put('/projects/{project}', [ProjectAdminController::class,'update'])->name('admin.projects.update')->middleware('project');
    Route::delete('/projects/{project}', [ProjectAdminController::class,'destroy'])->name('admin.projects.destroy')->middleware('project');
    Route::post('/projects/{project}/export', [ProjectAdminController::class,'export'])->name('admin.projects.export')->middleware('project');
});
