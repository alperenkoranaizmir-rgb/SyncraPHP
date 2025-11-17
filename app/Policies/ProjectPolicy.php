<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Project $project)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Project $project)
    {
        return true;
    }

    public function delete(User $user, Project $project)
    {
        return true;
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
