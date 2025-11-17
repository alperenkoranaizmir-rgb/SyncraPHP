<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Unit;

class UnitPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Unit $unit)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Unit $unit)
    {
        return true;
    }

    public function delete(User $user, Unit $unit)
    {
        return true;
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
