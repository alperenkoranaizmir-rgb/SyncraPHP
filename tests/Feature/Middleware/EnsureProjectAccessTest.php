<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

it('sets current_project_id from bound project model', function () {
    config(['auth.guards.sanctum' => ['driver' => 'session', 'provider' => 'users']]);
    $user = User::factory()->create();
    $project = Project::create(['name' => 'Mtest']);

    Route::get('/__test-project/{project}', function (Request $request) {
        return response()->json([
            'attr' => $request->attributes->get('current_project_id'),
            'session' => session('current_project_id'),
        ]);
    })->middleware('project');

    $resp = $this->actingAs($user, 'sanctum')->getJson('/__test-project/' . $project->id);
    $resp->assertStatus(200);
    $resp->assertJson(['attr' => $project->id, 'session' => $project->id]);
});

it('reads current_project_id from X-Project-Id header when provided', function () {
    config(['auth.guards.sanctum' => ['driver' => 'session', 'provider' => 'users']]);
    $user = User::factory()->create();
    $project = Project::create(['name' => 'HeaderTest']);

    Route::get('/__test-header', function (Request $request) {
        return response()->json([
            'attr' => $request->attributes->get('current_project_id'),
            'session' => session('current_project_id'),
        ]);
    })->middleware('project');

    $resp = $this->actingAs($user, 'sanctum')->getJson('/__test-header', ['X-Project-Id' => $project->id]);
    $resp->assertStatus(200);
    $resp->assertJson(['attr' => $project->id, 'session' => $project->id]);
});
