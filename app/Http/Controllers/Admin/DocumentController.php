<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\Document;
use App\Http\Requests\DocumentRequest;

class DocumentController extends Controller
{
    public function index(Project $project)
    {
        $docs = Document::where('project_id', $project->id)->paginate(25);
        return view('admin.projects.documents.index', compact('project','docs'));
    }

    public function create(Project $project)
    {
        return view('admin.projects.documents.form', compact('project'));
    }

    public function store(DocumentRequest $request, Project $project)
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents', 'projects');
            $data['file_path'] = $path;
            $data['uploaded_by_user_id'] = auth()->id();
            $data['uploaded_at'] = now();
        }
        $data['project_id'] = $project->id;
        Document::create($data);
        return redirect()->route('admin.projects.documents.index', ['project' => $project->id])->with('success', 'Belge yüklendi.');
    }

    public function show(Project $project, Document $doc)
    {
        return view('admin.projects.documents.show', compact('project','doc'));
    }

    public function download(Project $project, Document $doc)
    {
        if (!$doc->file_path || !Storage::disk('projects')->exists($doc->file_path)) {
            abort(404);
        }
        return Storage::disk('projects')->download($doc->file_path);
    }

    public function destroy(Project $project, Document $doc)
    {
        if ($doc->file_path) {
            Storage::disk('projects')->delete($doc->file_path);
        }
        $doc->delete();
        return redirect()->route('admin.projects.documents.index', ['project' => $project->id])->with('success', 'Belge silindi.');
    }
}
