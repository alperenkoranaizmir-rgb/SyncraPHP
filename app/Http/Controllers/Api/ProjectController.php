<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // Show projects scoped to user unless user has global permission
        $query = Project::query();
        if (! $request->user() || ! $request->user()->hasPermission('proje.yonetim')) {
            if ($request->user()) {
                $query->whereIn('id', $request->user()->projects()->pluck('projects.id'));
            } else {
                $query->whereRaw('1=0');
            }
        }
        $projects = $query->paginate(20);
        return response()->json($projects);
    }

    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);
        $data = $request->validated();
        $project = Project::create($data);
        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return response()->json($project->load(['units','owners','decisions']));
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $project->update($request->validated());
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return response()->json(null,204);
    }
}
