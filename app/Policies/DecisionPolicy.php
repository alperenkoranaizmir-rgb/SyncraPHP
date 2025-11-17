<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Decision;

class DecisionPolicy
{
    public function viewAny(User $user)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('decisions.viewAny')) {
            return true;
        }
        return $user->projects()->exists();
    }

    public function view(User $user, Decision $decision)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('decisions.view')) {
            return true;
        }
        return $user->projects()->where('projects.id', $decision->project_id)->exists();
    }

    public function create(User $user)
    {
        return method_exists($user, 'hasPermission') && $user->hasPermission('decisions.create');
    }

    public function update(User $user, Decision $decision)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('decisions.update')) {
            return true;
        }
        return $user->projects()->where('projects.id', $decision->project_id)->exists();
    }

    public function delete(User $user, Decision $decision)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('decisions.delete')) {
            return true;
        }
        return $user->projects()->where('projects.id', $decision->project_id)->exists();
    }
}
<?php

namespace App\Policies;

use App\Models\Decision;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DecisionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Decision $decision)
    {
        if ($user->hasPermission('proje.yonetim')) return true;
        return $user->projects()->where('projects.id', $decision->project_id)->exists();
    }

    public function create(User $user)
    {
        return $user->hasPermission('proje.yonetim') || $user->projects()->exists();
    }

    public function update(User $user, Decision $decision)
    {
        if ($user->hasPermission('proje.yonetim')) return true;
        return $user->projects()->where('projects.id', $decision->project_id)->exists();
    }
}
