<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Decision;

class DecisionPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Decision $decision)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Decision $decision)
    {
        return true;
    }

    public function delete(User $user, Decision $decision)
    {
        return true;
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
