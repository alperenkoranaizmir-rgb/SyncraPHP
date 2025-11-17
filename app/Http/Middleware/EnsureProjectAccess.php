<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class EnsureProjectAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Resolve project id from route, header or session
        $projectId = $request->route('project') ?? $request->header('X-Project-Id') ?? session('current_project_id');

        if (!$projectId && auth()->check() && property_exists(auth()->user(), 'current_project_id')) {
            $projectId = auth()->user()->current_project_id;
        }

        if ($projectId) {
            // If a Model was bound, convert to its primary key
            if ($projectId instanceof Model) {
                $projectId = $projectId->getKey();
            }
            // store resolved project id for later use
            $request->attributes->set('current_project_id', $projectId);
            session(['current_project_id' => $projectId]);
        }

        return $next($request);
    }
}
