<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Owner;

class OwnerPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Owner $owner)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Owner $owner)
    {
        return true;
    }

    public function delete(User $user, Owner $owner)
    {
        return true;
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
