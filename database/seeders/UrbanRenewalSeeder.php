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
