<?php

use App\Jobs\CheckDecisionMajorityJob;
use App\Models\Project;
use App\Models\Decision;
use App\Models\Owner;
use App\Models\Signature;
use App\Models\Unit;
use App\Models\OwnerUnit;

it('job updates decision status when majority reached', function () {
    $project = Project::create(['name' => 'JobProj']);
    $u1 = Unit::create(['project_id' => $project->id, 'unit_no' => '1']);
    $u2 = Unit::create(['project_id' => $project->id, 'unit_no' => '2']);

    $o1 = Owner::create(['project_id' => $project->id, 'first_name' => 'O1', 'last_name' => 'A']);
    $o2 = Owner::create(['project_id' => $project->id, 'first_name' => 'O2', 'last_name' => 'B']);

    OwnerUnit::create(['owner_id' => $o1->id, 'unit_id' => $u1->id, 'share_percent' => 50.00]);
    OwnerUnit::create(['owner_id' => $o2->id, 'unit_id' => $u2->id, 'share_percent' => 50.00]);

    $decision = Decision::create(['project_id' => $project->id, 'title' => 'Job Decision', 'status' => 'taslak']);

    Signature::create(['decision_id' => $decision->id, 'owner_id' => $o1->id, 'signed' => true, 'signed_at' => now()]);

    // dispatch job synchronously
    (new CheckDecisionMajorityJob($decision))->handle(new \App\Services\DecisionService());

    $this->assertNotEquals('taslak', $decision->fresh()->status);
});
