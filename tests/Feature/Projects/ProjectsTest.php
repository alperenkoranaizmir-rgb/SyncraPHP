<?php

/**
 * @mixin \Tests\TestCase
 */

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Decision;
use App\Models\Owner;
use App\Models\Signature;
use App\Models\Document;
use App\Services\DecisionService;
use Illuminate\Support\Facades\Storage;


it('returns only projects assigned to the user when no global permission', function () {
    /** @var \Tests\TestCase $this */
    // define a simple sanctum guard for the test runtime
    config(['auth.guards.sanctum' => ['driver' => 'session', 'provider' => 'users']]);
    $user = User::factory()->create();

    $p1 = Project::create(['name' => 'P1']);
    $p2 = Project::create(['name' => 'P2']);

    ProjectUser::create(['user_id' => $user->id, 'project_id' => $p1->id]);

    $resp = $this->actingAs($user, 'sanctum')->getJson('/api/projects');
    $resp->assertStatus(200);
    $data = $resp->json('data');
    $ids = array_column($data, 'id');
    expect(in_array($p1->id, $ids))->toBeTrue();
    expect(in_array($p2->id, $ids))->toBeFalse();
});

it('forbids project creation for users without proje.yonetim permission', function () {
    /** @var \Tests\TestCase $this */
    config(['auth.guards.sanctum' => ['driver' => 'session', 'provider' => 'users']]);
    $user = User::factory()->create();
    $resp = $this->actingAs($user, 'sanctum')->postJson('/api/projects', ['name' => 'NewProj']);
    $resp->assertStatus(403);
});

it('allows users with proje.yonetim permission to create projects', function () {
    /** @var \Tests\TestCase $this */
    config(['auth.guards.sanctum' => ['driver' => 'session', 'provider' => 'users']]);
    $user = User::factory()->create();

    $perm = Permission::create(['izin_adi' => 'proje.yonetim', 'aciklama' => 'Projeleri yönetir', 'aktif' => 1]);
    $role = Role::create(['rol_adi' => 'admin', 'rol_aciklama' => 'Sistem yöneticisi', 'aktif' => 1]);
    $role->permissions()->attach($perm->id);
    $user->roles()->attach($role->id);

    $resp = $this->actingAs($user, 'sanctum')->postJson('/api/projects', ['name' => 'NewProj']);
    $resp->assertStatus(201);
    $resp->assertJsonFragment(['name' => 'NewProj']);
});

it('calculates decision majority and marks decision tamamlandi when threshold reached', function () {
    $user = User::factory()->create();
    $project = Project::create(['name' => 'DecProj', 'total_units' => 3]);

    // create owners for signatures
    $o1 = Owner::create(['project_id' => $project->id, 'first_name' => 'A', 'last_name' => 'One']);
    $o2 = Owner::create(['project_id' => $project->id, 'first_name' => 'B', 'last_name' => 'Two']);
    $o3 = Owner::create(['project_id' => $project->id, 'first_name' => 'C', 'last_name' => 'Three']);

    $decision = Decision::create(['project_id' => $project->id, 'title' => 'Test Decision', 'created_by_user_id' => $user->id]);

    // create signatures and sign two of them (required 2 of 3)
    Signature::create(['decision_id' => $decision->id, 'owner_id' => $o1->id, 'signed' => true, 'signed_at' => now()]);
    Signature::create(['decision_id' => $decision->id, 'owner_id' => $o2->id, 'signed' => true, 'signed_at' => now()]);
    Signature::create(['decision_id' => $decision->id, 'owner_id' => $o3->id, 'signed' => false]);

    $service = new DecisionService();
    $result = $service->calculateMajority($decision->fresh());

    // total should be the project's total_units (3)
    $this->assertEquals(3, $result['total']);
    // required should be 2 for total_units=3
    $this->assertEquals(2, $result['required']);
    $this->assertEquals(2, $result['signed']);

    $this->assertEquals('tamamlandi', $decision->fresh()->status);
});

it('exports project documents as zip when documents exist', function () {
    /** @var \Tests\TestCase $this */
    Storage::fake('projects');

    config(['auth.guards.sanctum' => ['driver' => 'session', 'provider' => 'users']]);

    $user = User::factory()->create();
    $project = Project::create(['name' => 'DocProj']);
    ProjectUser::create(['user_id' => $user->id, 'project_id' => $project->id]);

    // put files on projects disk
    Storage::disk('projects')->put('file1.txt', 'hello');
    Storage::disk('projects')->put('file2.txt', 'world');

    Document::create(['project_id' => $project->id, 'file_path' => 'file1.txt']);
    Document::create(['project_id' => $project->id, 'file_path' => 'file2.txt']);

    $resp = $this->actingAs($user, 'sanctum')->postJson('/api/projects/'.$project->id.'/documents/export');
    $resp->assertStatus(200);
    $resp->assertJsonStructure(['zip','download_url']);
});
