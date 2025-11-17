<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    public function viewAny(User $user)
    {
        // allow if user has an overarching admin permission
        if (method_exists($user, 'hasPermission') && $user->hasPermission('projects.viewAny')) {
            return true;
        }
        // otherwise allow if user belongs to any project
        return $user->projects()->exists();
    }

    public function view(User $user, Project $project)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('projects.view')) {
            return true;
        }
        return $user->projects()->where('projects.id', $project->id)->exists();
    }

    public function create(User $user)
    {
        return method_exists($user, 'hasPermission') && $user->hasPermission('projects.create');
    }

    public function update(User $user, Project $project)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('projects.update')) {
            return true;
        }
        return $user->projects()->where('projects.id', $project->id)->exists();
    }

    public function delete(User $user, Project $project)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('projects.delete')) {
            return true;
        }
        return $user->projects()->where('projects.id', $project->id)->exists();
    }
}
<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Project $project)
    {
        if ($user->hasPermission('proje.yonetim')) {
            return true;
        }
        return $user->id === $project->manager_id || $user->projectUsers()->where('project_id',$project->id)->exists();
    }

    public function create(User $user)
    {
        // Only users with explicit project management permission can create projects
        return $user->hasPermission('proje.yonetim');
    }

    public function update(User $user, Project $project)
    {
        if ($user->hasPermission('proje.yonetim')) {
            return true;
        }
        return $user->id === $project->manager_id || $user->projectUsers()->where('project_id',$project->id)->whereIn('gorev',['koordinator','proje_sorumlusu'])->exists();
    }

    public function delete(User $user, Project $project)
    {
        if ($user->hasPermission('proje.yonetim')) {
            return true;
        }
        return $user->projectUsers()->where('project_id',$project->id)
            ->whereIn('gorev',['koordinator','proje_sorumlusu'])->exists();
    }
}
