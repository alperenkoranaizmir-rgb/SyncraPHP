<?php

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExportProjectDocumentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $projectId;

    public function __construct(int $projectId)
    {
        $this->projectId = $projectId;
    }

    public function handle()
    {
        $project = Project::find($this->projectId);
        if (!$project) return;

        $disk = Storage::disk('projects');
        $files = $project->documents()->pluck('file_path')->toArray();
        if (empty($files)) return;

        $tmpZip = storage_path('app/projects/exports/project_'.$project->id.'_'.time().'.zip');
        @mkdir(dirname($tmpZip), 0755, true);
        $zip = new \ZipArchive();
        if ($zip->open($tmpZip, \ZipArchive::CREATE)!==true) return;

        foreach ($files as $file) {
            $full = $disk->path($file);
            if (file_exists($full)) {
                $zip->addFile($full, basename($file));
            }
        }
        $zip->close();

        // store and optionally notify
        $disk->putFileAs('exports', new \Illuminate\Http\UploadedFile($tmpZip, basename($tmpZip)), basename($tmpZip));
    }
}
