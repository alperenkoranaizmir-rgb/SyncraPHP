<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOwnerRequest;
use App\Models\Owner;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    public function index(Project $project)
    {
        $owners = $project->owners()->paginate(20);
        return response()->json($owners);
    }

    public function store(StoreOwnerRequest $request, Project $project)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('owners','projects');
        }
        if (isset($data['disability_report'])) {
            $data['disability_report_path'] = $request->file('disability_report')->store('owners/reports','projects');
        }
        $data['project_id'] = $project->id;
        $owner = Owner::create($data);
        return response()->json($owner,201);
    }

    public function show(Project $project, Owner $owner)
    {
        return response()->json($owner->load(['units','documents','signatures']));
    }

    public function update(StoreOwnerRequest $request, Project $project, Owner $owner)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('owners','projects');
        }
        $owner->update($data);
        return response()->json($owner);
    }

    public function destroy(Project $project, Owner $owner)
    {
        $this->authorize('delete', $owner);
        $owner->delete();
        return response()->json(null,204);
    }
}
