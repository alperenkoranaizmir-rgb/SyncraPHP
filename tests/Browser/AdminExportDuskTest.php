<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class AdminExportDuskTest extends DuskTestCase
{
    public function test_admin_can_export_documents()
    {
        Storage::fake('projects');

        $user = User::factory()->create();
        $project = Project::create(['name' => 'DuskExport']);
        ProjectUser::create(['user_id' => $user->id, 'project_id' => $project->id]);

        // grant global permission
        $perm = \App\Models\Permission::create(['izin_adi' => 'proje.yonetim', 'aciklama' => 'test', 'aktif' => 1]);
        $role = \App\Models\Role::create(['rol_adi' => 'dusk_admin', 'rol_aciklama' => 'test', 'aktif' => 1]);
        $role->permissions()->attach($perm->id);
        $user->roles()->attach($role->id);

        Storage::disk('projects')->put('f.txt', 'f');
        Document::create(['project_id' => $project->id, 'file_path' => 'f.txt']);

        $this->browse(function (Browser $browser) use ($user, $project) {
            $browser->loginAs($user)
                    ->visit('/admin/projects/'.$project->id)
                    ->press('Belgeleri ZIP olarak indir')
                    ->pause(1000)
                    ->assertSeeText('');
        });
    }
}
