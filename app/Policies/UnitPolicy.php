<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Unit;

class UnitPolicy
{
    public function viewAny(User $user)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('units.viewAny')) {
            return true;
        }
        return $user->projects()->exists();
    }

    public function view(User $user, Unit $unit)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('units.view')) {
            return true;
        }
        return $user->projects()->where('projects.id', $unit->project_id)->exists();
    }

    public function create(User $user)
    {
        return method_exists($user, 'hasPermission') && $user->hasPermission('units.create');
    }

    public function update(User $user, Unit $unit)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('units.update')) {
            return true;
        }
        return $user->projects()->where('projects.id', $unit->project_id)->exists();
    }

    public function delete(User $user, Unit $unit)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('units.delete')) {
            return true;
        }
        return $user->projects()->where('projects.id', $unit->project_id)->exists();
    }
}
<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Unit $unit)
    {
        return $user->projectUsers()->where('project_id',$unit->project_id)->exists();
    }

    public function delete(User $user, Unit $unit)
    {
        return $user->projectUsers()->where('project_id',$unit->project_id)->whereIn('role',['koordinator','proje_sorumlusu'])->exists();
    }
}
