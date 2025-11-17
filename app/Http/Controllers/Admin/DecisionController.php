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

        // compute percentage for each decision using DecisionService
        $service = new \App\Services\DecisionService();
        $decisions = $decisions->map(function ($d) use ($service) {
            $eval = $service->evaluateMajority($d);
            $d->percentage = $eval['percentage'] ?? 0;
            $d->signed_shares = $eval['signed_shares'] ?? 0;
            $d->total_shares = $eval['total_shares'] ?? 0;
            return $d;
        });

        return view('admin.projects.decisions.index', compact('decisions', 'projectId'));
    }

    public function show($projectId, Decision $decision)
    {
        // load owners for the project and existing signatures
        $owners = Owner::where('project_id', $projectId)->get();
        $signatures = Signature::where('decision_id', $decision->id)->get()->keyBy('owner_id');

        return view('admin.projects.decisions.show', compact('decision', 'owners', 'signatures', 'projectId'));
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

        $service = new \App\Services\DecisionService();
        $eval = $service->evaluateMajority($decision);

        return response()->json(['ok' => true, 'signature' => $signature, 'eval' => $eval]);
    }
}
