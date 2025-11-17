<?php

/**
 * @mixin \Tests\TestCase
 */

use App\Models\Project;
use App\Models\User;
use App\Models\Document;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\Storage;

it('admin can export project documents and is redirected to download url', function () {
    /** @var \Tests\TestCase $this */
    config(['auth.guards.web' => ['driver' => 'session', 'provider' => 'users']]);

    $user = User::factory()->create();
    $project = Project::create(['name' => 'ExportProject']);
    ProjectUser::create(['user_id' => $user->id, 'project_id' => $project->id]);

    Storage::fake('projects');
    Storage::disk('projects')->put('a.txt', 'a');
    Document::create(['project_id' => $project->id, 'file_path' => 'a.txt']);

    // grant permission
    // give user proje.yonetim to allow export
    $perm = \App\Models\Permission::create(['izin_adi' => 'proje.yonetim', 'aciklama' => 'projeleri yönetir', 'aktif' => 1]);
    $role = \App\Models\Role::create(['rol_adi' => 'admin_test', 'rol_aciklama' => 'test', 'aktif' => 1]);
    $role->permissions()->attach($perm->id);
    $user->roles()->attach($role->id);

    $resp = $this->actingAs($user)->post('/admin/projects/'.$project->id.'/export');
    $resp->assertStatus(302);
    $location = $resp->headers->get('Location');
    $this->assertStringContainsString('/storage/projects/exports/', $location);
});
