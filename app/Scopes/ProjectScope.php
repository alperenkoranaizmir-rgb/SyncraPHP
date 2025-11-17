<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class ProjectScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
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

        if (Auth::check() && !$projectId) {
            // Optionally use user's current_project_id if exists
            if (property_exists(Auth::user(), 'current_project_id')) {
                $projectId = Auth::user()->current_project_id;
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
