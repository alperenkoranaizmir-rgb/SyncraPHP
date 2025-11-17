<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;

class DocumentPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Document $doc)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Document $doc)
    {
        return true;
    }

    public function delete(User $user, Document $doc)
    {
        return true;
    }
}
<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Document $document)
    {
        if ($user->hasPermission('document.view') || $user->hasPermission('proje.yonetim')) {
            return true;
        }
        return $user->projects()->where('projects.id', $document->project_id)->exists();
    }

    public function create(User $user, $projectId = null)
    {
        if ($user->hasPermission('document.create') || $user->hasPermission('proje.yonetim')) return true;
        if ($projectId) {
            return $user->projects()->where('projects.id', $projectId)->exists();
        }
        return $user->projects()->exists();
    }

    public function delete(User $user, Document $document)
    {
        if ($user->hasPermission('document.delete') || $user->hasPermission('proje.yonetim')) return true;
        return $user->projects()->where('projects.id', $document->project_id)->exists();
    }
}

