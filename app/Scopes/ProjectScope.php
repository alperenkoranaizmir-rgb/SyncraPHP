<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ProjectScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Only apply when model has project_id column
        if (!SchemaHasColumn($model->getTable(), 'project_id')) {
            return;
        }

        $projectId = null;
        if (request()) {
            $projectId = request()->route('project') ?? request()->header('X-Project-Id') ?? session('current_project_id');
        }

        if (auth()->check() && !$projectId) {
            // Optionally use user's current_project_id if exists
            if (property_exists(auth()->user(), 'current_project_id')) {
                $projectId = auth()->user()->current_project_id;
            }
        }

        if ($projectId) {
            // if a model instance was bound in the route, extract the key
            if ($projectId instanceof Model) {
                $projectId = $projectId->getKey();
            }
            $builder->where($model->getTable() . '.project_id', $projectId);
        }
    }
}

function SchemaHasColumn($table, $column)
{
    try {
        return \Illuminate\Support\Facades\Schema::hasColumn($table, $column);
    } catch (\Exception $e) {
        return false;
    }
}
