<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DocumentController extends Controller
{
    public function exportProjectDocuments(Project $project)
    {
        $timestamp = now()->format('YmdHis');
        $exportDir = storage_path('app/exports');
        if (!is_dir($exportDir)) {
            mkdir($exportDir, 0755, true);
        }

        $zipPath = $exportDir.'/project-'.$project->id.'-'.$timestamp.'.zip';
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
            return response()->json(['message' => 'Could not create zip file'], 500);
        }

        // add units CSV
        $units = $project->units()->get()->toArray();
        $unitsCsv = $exportDir.'/units-'.$project->id.'-'.$timestamp.'.csv';
        $f = fopen($unitsCsv, 'w');
        if ($f) {
            if (count($units)) {
                fputcsv($f, array_keys($units[0]));
                foreach ($units as $row) fputcsv($f, $row);
            }
            fclose($f);
            $zip->addFile($unitsCsv, 'units.csv');
        }

        // add owners CSV
        $owners = $project->owners()->get()->toArray();
        $ownersCsv = $exportDir.'/owners-'.$project->id.'-'.$timestamp.'.csv';
        $f2 = fopen($ownersCsv, 'w');
        if ($f2) {
            if (count($owners)) {
                fputcsv($f2, array_keys($owners[0]));
                foreach ($owners as $row) fputcsv($f2, $row);
            }
            fclose($f2);
            $zip->addFile($ownersCsv, 'owners.csv');
        }

        // add documents files from projects disk
        $docs = $project->documents()->get();
        foreach ($docs as $doc) {
            if ($doc->file_path && Storage::disk('projects')->exists($doc->file_path)) {
                $localPath = Storage::disk('projects')->path($doc->file_path);
                $zip->addFile($localPath, 'documents/'.basename($doc->file_path));
            }
        }

        $zip->close();

        // make file available via storage/public/exports by moving it
        $publicExports = storage_path('app/public/exports');
        if (!is_dir($publicExports)) mkdir($publicExports, 0755, true);
        $publicName = 'project-'.$project->id.'-'.$timestamp.'.zip';
        copy($zipPath, $publicExports.'/'.$publicName);

        $url = asset('storage/exports/'.$publicName);
        return response()->json(['download_url' => $url]);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index(Project $project)
    {
        $docs = $project->documents()->paginate(20);
        return response()->json($docs);
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'files.*' => 'required|file|max:51200',
            'doc_type' => 'nullable|string',
            'unit_id' => 'nullable|exists:units,id',
            'owner_id' => 'nullable|exists:owners,id',
        ]);

        $uploaded = [];
        foreach ($request->file('files', []) as $file) {
            $path = $file->store('documents', 'projects');
            $doc = Document::create([
                'project_id' => $project->getKey(),
                'unit_id' => $request->input('unit_id'),
                'owner_id' => $request->input('owner_id'),
                'doc_type' => $request->input('doc_type'),
                'file_path' => $path,
                'uploaded_by_user_id' => $request->user()?->id ?? Auth::id(),
                'uploaded_at' => now(),
            ]);
            $uploaded[] = $doc;
        }

        return response()->json($uploaded, 201);
    }

    public function download(Project $project, Document $document)
    {
        // authorize project scoping
        if ($document->project_id !== $project->id) {
            return response()->json(['message' => 'Not found'],404);
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('projects');
        if ($disk->exists($document->file_path)) {
            // if using s3: temporaryUrl, else download
            if (method_exists($disk, 'temporaryUrl')) {
                $url = $disk->temporaryUrl($document->file_path, now()->addMinutes(30));
                return response()->json(['url' => $url]);
            }
            return $disk->download($document->file_path);
        }

        return response()->json(['message' => 'File not found'],404);
    }

    public function exportProjectDocuments(Project $project)
    {
        // create zip of all project documents
        $disk = Storage::disk('projects');
        $files = $project->documents()->pluck('file_path')->toArray();
        if (empty($files)) return response()->json(['message'=>'No documents'],400);

        $tmpZip = storage_path('app/projects/exports/project_'.$project->getKey().'_'.time().'.zip');
        @mkdir(dirname($tmpZip), 0755, true);

        $zip = new ZipArchive();
        if ($zip->open($tmpZip, ZipArchive::CREATE)!==true) {
            return response()->json(['message'=>'Could not create zip'],500);
        }

        foreach ($files as $file) {
            $full = Storage::disk('projects')->path($file);
            if (file_exists($full)) {
                $zip->addFile($full, basename($file));
            }
        }
        $zip->close();

        // store zip in projects disk for retrieval
        $zipPath = 'exports/'.basename($tmpZip);
        $disk->putFileAs('exports', new \Illuminate\Http\UploadedFile($tmpZip, basename($tmpZip)), basename($tmpZip));

        return response()->json(['zip' => $zipPath, 'download_url' => url('/storage/projects/exports/'.basename($tmpZip))]);
    }
}
