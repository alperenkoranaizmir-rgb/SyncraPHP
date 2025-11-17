<?php

/**
 * @mixin \Tests\TestCase
 */

use App\Models\User;
use App\Models\Project;

it('admin index page loads for authenticated user', function () {
    /** @var \Tests\TestCase $this */
    $user = User::factory()->create();
    $this->actingAs($user)->get('/admin/projects')->assertStatus(200);
});

it('can create a project via admin UI', function () {
    /** @var \Tests\TestCase $this */
    $user = User::factory()->create();
    $this->actingAs($user)->post('/admin/projects', ['name' => 'UIProj'])->assertRedirect();
    $this->assertDatabaseHas('projects', ['name' => 'UIProj']);
});

it('can edit a project via admin UI', function () {
    /** @var \Tests\TestCase $this */
    $user = User::factory()->create();
    $project = Project::create(['name' => 'ToEdit']);
    $this->actingAs($user)->put('/admin/projects/'.$project->id, ['name' => 'Edited'])->assertRedirect();
    $this->assertDatabaseHas('projects', ['name' => 'Edited']);
});
