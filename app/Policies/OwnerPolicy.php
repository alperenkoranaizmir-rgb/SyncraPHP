<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Owner;

class OwnerPolicy
{
    public function viewAny(User $user)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('owners.viewAny')) {
            return true;
        }
        return $user->projects()->exists();
    }

    public function view(User $user, Owner $owner)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('owners.view')) {
            return true;
        }
        return $user->projects()->where('projects.id', $owner->project_id)->exists();
    }

    public function create(User $user)
    {
        return method_exists($user, 'hasPermission') && $user->hasPermission('owners.create');
    }

    public function update(User $user, Owner $owner)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('owners.update')) {
            return true;
        }
        return $user->projects()->where('projects.id', $owner->project_id)->exists();
    }

    public function delete(User $user, Owner $owner)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('owners.delete')) {
            return true;
        }
        return $user->projects()->where('projects.id', $owner->project_id)->exists();
    }
}
<?php

namespace App\Policies;

use App\Models\Owner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OwnerPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Owner $owner)
    {
        return $user->projectUsers()->where('project_id',$owner->project_id)->exists();
    }

    public function delete(User $user, Owner $owner)
    {
        return $user->projectUsers()->where('project_id',$owner->project_id)->whereIn('role',['koordinator','proje_sorumlusu'])->exists();
    }
}
