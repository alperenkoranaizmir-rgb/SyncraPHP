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
    // Decisions
    Route::get('/projects/{project}/decisions', [\App\Http\Controllers\Admin\DecisionController::class,'index'])->name('admin.projects.decisions.index')->middleware('project');
    Route::post('/projects/{project}/decisions', [\App\Http\Controllers\Admin\DecisionController::class,'store'])->name('admin.projects.decisions.store')->middleware('project');
    Route::get('/projects/{project}/decisions/{decision}', [\App\Http\Controllers\Admin\DecisionController::class,'show'])->name('admin.projects.decisions.show')->middleware('project');
    Route::post('/decisions/{decision}/sign', [\App\Http\Controllers\Admin\DecisionController::class,'sign'])->name('admin.decisions.sign')->middleware('project');
    // Units
    Route::get('/projects/{project}/units', [\App\Http\Controllers\Admin\UnitController::class,'index'])->name('admin.projects.units.index')->middleware('project');
    Route::get('/projects/{project}/units/create', [\App\Http\Controllers\Admin\UnitController::class,'create'])->name('admin.projects.units.create')->middleware('project');
    Route::post('/projects/{project}/units', [\App\Http\Controllers\Admin\UnitController::class,'store'])->name('admin.projects.units.store')->middleware('project');
    Route::get('/projects/{project}/units/{unit}', [\App\Http\Controllers\Admin\UnitController::class,'show'])->name('admin.projects.units.show')->middleware('project');
    Route::get('/projects/{project}/units/{unit}/edit', [\App\Http\Controllers\Admin\UnitController::class,'edit'])->name('admin.projects.units.edit')->middleware('project');
    Route::put('/projects/{project}/units/{unit}', [\App\Http\Controllers\Admin\UnitController::class,'update'])->name('admin.projects.units.update')->middleware('project');
    Route::delete('/projects/{project}/units/{unit}', [\App\Http\Controllers\Admin\UnitController::class,'destroy'])->name('admin.projects.units.destroy')->middleware('project');
    // Owners
    Route::get('/projects/{project}/owners', [\App\Http\Controllers\Admin\OwnerController::class,'index'])->name('admin.projects.owners.index')->middleware('project');
    Route::get('/projects/{project}/owners/create', [\App\Http\Controllers\Admin\OwnerController::class,'create'])->name('admin.projects.owners.create')->middleware('project');
    Route::post('/projects/{project}/owners', [\App\Http\Controllers\Admin\OwnerController::class,'store'])->name('admin.projects.owners.store')->middleware('project');
    Route::get('/projects/{project}/owners/{owner}', [\App\Http\Controllers\Admin\OwnerController::class,'show'])->name('admin.projects.owners.show')->middleware('project');
    Route::get('/projects/{project}/owners/{owner}/edit', [\App\Http\Controllers\Admin\OwnerController::class,'edit'])->name('admin.projects.owners.edit')->middleware('project');
    Route::put('/projects/{project}/owners/{owner}', [\App\Http\Controllers\Admin\OwnerController::class,'update'])->name('admin.projects.owners.update')->middleware('project');
    Route::delete('/projects/{project}/owners/{owner}', [\App\Http\Controllers\Admin\OwnerController::class,'destroy'])->name('admin.projects.owners.destroy')->middleware('project');
    // Agreements
    Route::get('/projects/{project}/agreements', [\App\Http\Controllers\Admin\AgreementController::class,'index'])->name('admin.projects.agreements.index')->middleware('project');
    Route::get('/projects/{project}/agreements/create', [\App\Http\Controllers\Admin\AgreementController::class,'create'])->name('admin.projects.agreements.create')->middleware('project');
    Route::post('/projects/{project}/agreements', [\App\Http\Controllers\Admin\AgreementController::class,'store'])->name('admin.projects.agreements.store')->middleware('project');
    Route::get('/projects/{project}/agreements/{agreement}', [\App\Http\Controllers\Admin\AgreementController::class,'show'])->name('admin.projects.agreements.show')->middleware('project');
    Route::get('/projects/{project}/agreements/{agreement}/edit', [\App\Http\Controllers\Admin\AgreementController::class,'edit'])->name('admin.projects.agreements.edit')->middleware('project');
    Route::put('/projects/{project}/agreements/{agreement}', [\App\Http\Controllers\Admin\AgreementController::class,'update'])->name('admin.projects.agreements.update')->middleware('project');
    Route::delete('/projects/{project}/agreements/{agreement}', [\App\Http\Controllers\Admin\AgreementController::class,'destroy'])->name('admin.projects.agreements.destroy')->middleware('project');
    // Documents
    Route::get('/projects/{project}/documents', [\App\Http\Controllers\Admin\DocumentController::class,'index'])->name('admin.projects.documents.index')->middleware('project');
    Route::get('/projects/{project}/documents/create', [\App\Http\Controllers\Admin\DocumentController::class,'create'])->name('admin.projects.documents.create')->middleware('project');
    Route::post('/projects/{project}/documents', [\App\Http\Controllers\Admin\DocumentController::class,'store'])->name('admin.projects.documents.store')->middleware('project');
    Route::get('/projects/{project}/documents/{document}', [\App\Http\Controllers\Admin\DocumentController::class,'show'])->name('admin.projects.documents.show')->middleware('project');
    Route::get('/projects/{project}/documents/{document}/download', [\App\Http\Controllers\Admin\DocumentController::class,'download'])->name('admin.projects.documents.download')->middleware('project');
    Route::delete('/projects/{project}/documents/{document}', [\App\Http\Controllers\Admin\DocumentController::class,'destroy'])->name('admin.projects.documents.destroy')->middleware('project');
});
