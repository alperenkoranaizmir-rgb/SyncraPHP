<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectAdminController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(20);
        return view('admin.projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['units','owners','decisions']);
        return view('admin.projects.show', compact('project'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string',
            'start_date' => 'nullable|date',
            'est_end_date' => 'nullable|date',
        ]);

        $project = Project::create($data + ['created_at' => now(), 'updated_at' => now()]);
        return redirect()->route('admin.projects.show', $project)->with('success','Proje oluşturuldu');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string',
            'start_date' => 'nullable|date',
            'est_end_date' => 'nullable|date',
        ]);
        $project->update($data);
        return redirect()->route('admin.projects.show', $project)->with('success','Proje güncellendi');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success','Proje silindi');
    }

    public function export(Project $project)
    {
        // Reuse API controller export method and redirect to returned download url
        $resp = app(\App\Http\Controllers\Api\DocumentController::class)->exportProjectDocuments($project);
        $data = $resp->getData(true);
        if (isset($data['download_url'])) {
            return redirect($data['download_url']);
        }
        return redirect()->route('admin.projects.show', $project)->with('error', $data['message'] ?? 'Export failed');
    }
}
