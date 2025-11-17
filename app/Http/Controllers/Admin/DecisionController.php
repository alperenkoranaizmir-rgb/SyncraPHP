<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DecisionRequest;
use App\Jobs\CheckDecisionMajorityJob;
use App\Models\Decision;
use App\Models\Signature;
use App\Models\Owner;
use Illuminate\Http\Request;

class DecisionController extends Controller
{
    public function index($projectId)
    {
        $decisions = Decision::where('project_id', $projectId)->get();
        return view('admin.projects.decisions.index', compact('decisions', 'projectId'));
    }

    public function store(DecisionRequest $request, $projectId)
    {
        $data = $request->validated();
        $data['project_id'] = $projectId;
        $data['created_by_user_id'] = auth()->id();
        $decision = Decision::create($data);
        return redirect()->route('admin.projects.decisions.index', ['project' => $projectId]);
    }

    public function sign(Request $request, Decision $decision)
    {
        // expects owner_id param and signed boolean
        $ownerId = $request->input('owner_id');
        $signed = (bool) $request->input('signed');

        $signature = Signature::updateOrCreate(
            ['decision_id' => $decision->id, 'owner_id' => $ownerId],
            ['signed' => $signed, 'signed_at' => $signed ? now() : null]
        );

        // enqueue evaluation
        CheckDecisionMajorityJob::dispatch($decision);

        return response()->json(['ok' => true, 'signature' => $signature]);
    }
}
