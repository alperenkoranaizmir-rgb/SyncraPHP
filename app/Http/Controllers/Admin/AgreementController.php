<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Agreement;
use App\Http\Requests\AgreementRequest;

class AgreementController extends Controller
{
    public function index(Project $project)
    {
        $agreements = Agreement::where('project_id', $project->id)->paginate(25);
        return view('admin.projects.agreements.index', compact('project','agreements'));
    }

    public function create(Project $project)
    {
        return view('admin.projects.agreements.form', compact('project'));
    }

    public function store(AgreementRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['project_id'] = $project->id;
        Agreement::create($data);
        return redirect()->route('admin.projects.agreements.index', ['project' => $project->id])->with('success', 'Anlaşma kaydedildi.');
    }

    public function show(Project $project, Agreement $agreement)
    {
        return view('admin.projects.agreements.show', compact('project','agreement'));
    }

    public function edit(Project $project, Agreement $agreement)
    {
        return view('admin.projects.agreements.form', compact('project','agreement'));
    }

    public function update(AgreementRequest $request, Project $project, Agreement $agreement)
    {
        $agreement->update($request->validated());
        return redirect()->route('admin.projects.agreements.index', ['project' => $project->id])->with('success', 'Anlaşma güncellendi.');
    }

    public function destroy(Project $project, Agreement $agreement)
    {
        $agreement->delete();
        return redirect()->route('admin.projects.agreements.index', ['project' => $project->id])->with('success', 'Anlaşma silindi.');
    }
}
