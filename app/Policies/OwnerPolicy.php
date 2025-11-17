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
