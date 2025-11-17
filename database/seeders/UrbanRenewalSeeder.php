<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Unit;
use App\Models\Owner;
use App\Models\Decision;
use App\Models\Signature;

class UrbanRenewalSeeder extends Seeder
{
    public function run()
    {
        $project = Project::factory()->create(['name' => 'Demo Kentsel Dönüşüm Projesi']);

        $units = Unit::factory()->count(5)->make()->each(function($u) use ($project) {
            $u->project_id = $project->id;
            $u->save();
        });

        $owners = Owner::factory()->count(4)->make()->each(function($o) use ($project) {
            $o->project_id = $project->id;
            $o->save();
        });

        // attach owners to units with share_percent
        $units = Unit::where('project_id', $project->id)->get();
        $owners = Owner::where('project_id', $project->id)->get();

        foreach ($units as $unit) {
            foreach ($owners as $i => $owner) {
                $unit->owners()->attach($owner->id, ['share_percent' => intdiv(100, max(1, $owners->count()))]);
            }
        }

        $decision = Decision::factory()->create(['project_id' => $project->id, 'title' => 'Örnek Karar']);

        // simulate one signature
        $firstOwner = $owners->first();
        if ($firstOwner) {
            Signature::create([
                'decision_id' => $decision->id,
                'owner_id' => $firstOwner->id,
                'signed' => 1,
                'signed_at' => now(),
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Unit;
use App\Models\Owner;
use App\Models\OwnerUnit;

class UrbanRenewalSeeder extends Seeder
{
    public function run()
    {
        // create a sample project
        $project = Project::create([
            'name' => 'Örnek Kentsel Dönüşüm Projesi',
            'status' => 'active',
            'total_units' => 10,
        ]);

        // units
        $units = [];
        for ($i=1;$i<=10;$i++) {
            $units[] = Unit::create([
                'project_id' => $project->id,
                'unit_no' => 'D'.$i,
                'usage_status' => 'ev_sahibi',
            ]);
        }

        // owners and assign shares randomly but sum 100 per unit
        $owners = [];
        for ($i=1;$i<=15;$i++) {
            $owners[] = Owner::create([
                'project_id' => $project->id,
                'first_name' => 'Owner'.$i,
                'last_name' => 'Test',
            ]);
        }

        // assign one owner per unit with 100% for simplicity
        foreach ($units as $idx => $unit) {
            OwnerUnit::create([
                'owner_id' => $owners[$idx]->id,
                'unit_id' => $unit->id,
                'share_percent' => 100,
                'owner_type' => 'ev_sahibi',
            ]);
        }
    }
}
