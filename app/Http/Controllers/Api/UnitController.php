<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Models\Unit;
use App\Models\Project;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Project $project)
    {
        $units = $project->units()->paginate(20);
        return response()->json($units);
    }

    public function store(StoreUnitRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['project_id'] = $project->id;
        $unit = Unit::create($data);
        return response()->json($unit,201);
    }

    public function show(Project $project, Unit $unit)
    {
        return response()->json($unit->load(['ownerUnits','documents','agreements']));
    }

    public function update(StoreUnitRequest $request, Project $project, Unit $unit)
    {
        $unit->update($request->validated());
        return response()->json($unit);
    }

    public function destroy(Project $project, Unit $unit)
    {
        $this->authorize('delete', $unit);
        $unit->delete();
        return response()->json(null,204);
    }
}
