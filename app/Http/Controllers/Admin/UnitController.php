<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Unit;
use App\Http\Requests\UnitRequest;

class UnitController extends Controller
{
    public function index(Project $project)
    {
        $units = Unit::where('project_id', $project->id)->paginate(25);
        return view('admin.projects.units.index', [
            'project' => $project,
            'units' => $units,
        ]);
    }

    public function create(Project $project)
    {
        return view('admin.projects.units.form', ['project' => $project]);
    }

    public function store(UnitRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['project_id'] = $project->id;
        $unit = Unit::create($data);
        return redirect()->route('admin.projects.units.index', ['project' => $project->id])->with('success', 'Birim oluşturuldu.');
    }

    public function show(Project $project, Unit $unit)
    {
        return view('admin.projects.units.show', ['project' => $project, 'unit' => $unit]);
    }

    public function edit(Project $project, Unit $unit)
    {
        return view('admin.projects.units.form', ['project' => $project, 'unit' => $unit]);
    }

    public function update(UnitRequest $request, Project $project, Unit $unit)
    {
        $unit->update($request->validated());
        return redirect()->route('admin.projects.units.index', ['project' => $project->id])->with('success', 'Birim güncellendi.');
    }

    public function destroy(Project $project, Unit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.projects.units.index', ['project' => $project->id])->with('success', 'Birim silindi.');
    }
}
