<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDecisionRequest;
use App\Jobs\CheckDecisionMajorityJob;
use App\Models\Decision;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DecisionController extends Controller
{
    public function index(Project $project)
    {
        $decisions = $project->decisions()->withCount(['signatures'])->paginate(20);
        return response()->json($decisions);
    }

    public function store(StoreDecisionRequest $request, Project $project)
    {
        $data = $request->validated();
        $projectId = $project->getKey();
        $data['project_id'] = $projectId;
        $data['created_by_user_id'] = Auth::id();
        $decision = Decision::create($data);

        // create signature placeholders for owners
        foreach ($project->owners as $owner) {
            $decision->signatures()->create(['owner_id' => $owner->getKey()]);
        }

        // dispatch majority check
        CheckDecisionMajorityJob::dispatch($decision->getKey());

        return response()->json($decision, 201);
    }

    public function show(Project $project, Decision $decision)
    {
        return response()->json($decision->load('signatures.owner'));
    }
}
