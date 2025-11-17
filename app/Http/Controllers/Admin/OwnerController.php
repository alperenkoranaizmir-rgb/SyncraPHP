<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Owner;
use App\Http\Requests\OwnerRequest;

class OwnerController extends Controller
{
    public function index(Project $project)
    {
        $owners = Owner::where('project_id', $project->id)->paginate(25);
        return view('admin.projects.owners.index', compact('project','owners'));
    }

    public function create(Project $project)
    {
        return view('admin.projects.owners.form', compact('project'));
    }

    public function store(OwnerRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['project_id'] = $project->id;
        Owner::create($data);
        return redirect()->route('admin.projects.owners.index', ['project' => $project->id])->with('success', 'Sahip oluşturuldu.');
    }

    public function show(Project $project, Owner $owner)
    {
        return view('admin.projects.owners.show', compact('project','owner'));
    }

    public function edit(Project $project, Owner $owner)
    {
        return view('admin.projects.owners.form', compact('project','owner'));
    }

    public function update(OwnerRequest $request, Project $project, Owner $owner)
    {
        $owner->update($request->validated());
        return redirect()->route('admin.projects.owners.index', ['project' => $project->id])->with('success', 'Sahip güncellendi.');
    }

    public function destroy(Project $project, Owner $owner)
    {
        $owner->delete();
        return redirect()->route('admin.projects.owners.index', ['project' => $project->id])->with('success', 'Sahip silindi.');
    }
}
