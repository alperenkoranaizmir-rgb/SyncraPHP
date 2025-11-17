<?php

use App\Models\Project;
use App\Models\Decision;
use App\Models\Owner;
use App\Models\Signature;
use App\Models\Unit;
use App\Models\OwnerUnit;
use App\Services\DecisionService;

it('evaluates majority based on owner unit share percent', function () {
    $project = Project::create(['name' => 'SvcProj']);

    // create units and owners with shares
    $u1 = Unit::create(['project_id' => $project->id, 'unit_no' => '1']);
    $u2 = Unit::create(['project_id' => $project->id, 'unit_no' => '2']);

    $o1 = Owner::create(['project_id' => $project->id, 'first_name' => 'Owner1', 'last_name' => 'A']);
    $o2 = Owner::create(['project_id' => $project->id, 'first_name' => 'Owner2', 'last_name' => 'B']);

    // owner1 owns unit1 60%, owner2 owns unit2 40%
    OwnerUnit::create(['owner_id' => $o1->id, 'unit_id' => $u1->id, 'share_percent' => 60.00]);
    OwnerUnit::create(['owner_id' => $o2->id, 'unit_id' => $u2->id, 'share_percent' => 40.00]);

    $decision = Decision::create(['project_id' => $project->id, 'title' => 'Share decision']);

    // sign by owner1 only (60% of shares)
    Signature::create(['decision_id' => $decision->id, 'owner_id' => $o1->id, 'signed' => true, 'signed_at' => now()]);

    $service = new DecisionService();
    $res = $service->evaluateMajority($decision);

    expect($res['total_shares'])->toBe(100.0);
    expect($res['signed_shares'])->toBe(60.0);
    expect($res['passed'])->toBeTrue();
});
