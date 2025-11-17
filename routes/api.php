<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\OwnerController;
use App\Http\Controllers\Api\DecisionController;
use App\Http\Controllers\Api\SignatureController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('projects.units', UnitController::class)->shallow()->middleware('project');
    Route::apiResource('projects.owners', OwnerController::class)->shallow()->middleware('project');
    Route::apiResource('projects.documents', \App\Http\Controllers\Api\DocumentController::class)->shallow()->middleware('project');
    Route::post('projects/{project}/documents/export', [\App\Http\Controllers\Api\DocumentController::class,'exportProjectDocuments'])->middleware('project');

    Route::get('projects/{project}/decisions', [DecisionController::class,'index'])->middleware('project');
    Route::post('projects/{project}/decisions', [DecisionController::class,'store'])->middleware('project');
    Route::get('projects/{project}/decisions/{decision}', [DecisionController::class,'show'])->middleware('project');

    Route::post('decisions/{decision}/sign', [SignatureController::class,'sign'])->middleware('project');

    // User management API
    Route::get('kullanicilar', [\App\Http\Controllers\Api\UserController::class,'index']);
    Route::post('kullanici', [\App\Http\Controllers\Api\UserController::class,'store']);
    Route::put('kullanici/{user}', [\App\Http\Controllers\Api\UserController::class,'update']);
    Route::delete('kullanici/{user}', [\App\Http\Controllers\Api\UserController::class,'destroy']);
    Route::get('kullanici/{user}', [\App\Http\Controllers\Api\UserController::class,'show']);
    Route::get('kullanici/{user}/roller', [\App\Http\Controllers\Api\UserController::class,'roles']);
    Route::post('kullanici/{user}/rol-ekle', [\App\Http\Controllers\Api\UserController::class,'addRole']);
    Route::post('kullanici/{user}/grup-ekle', [\App\Http\Controllers\Api\UserController::class,'addGroup']);
    Route::get('kullanici/{user}/projeler', [\App\Http\Controllers\Api\UserController::class,'projects']);

    // personnel files
    Route::get('kullanici/{user}/dosyalar', [\App\Http\Controllers\Api\PersonnelFileController::class,'index']);
    Route::post('kullanici/{user}/dosyalar', [\App\Http\Controllers\Api\PersonnelFileController::class,'store']);
    Route::get('dosyalar/{personel_dosyalari}', [\App\Http\Controllers\Api\PersonnelFileController::class,'show']);
    Route::delete('dosyalar/{personel_dosyalari}', [\App\Http\Controllers\Api\PersonnelFileController::class,'destroy']);

    // Groups & Roles
    Route::apiResource('gruplar', \App\Http\Controllers\Api\GroupController::class);
    Route::apiResource('roller', \App\Http\Controllers\Api\RoleController::class);
});
