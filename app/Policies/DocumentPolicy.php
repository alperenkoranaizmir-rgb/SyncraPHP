<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;

class DocumentPolicy
{
    public function viewAny(User $user)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('documents.viewAny')) {
            return true;
        }
        return $user->projects()->exists();
    }

    public function view(User $user, Document $doc)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('documents.view')) {
            return true;
        }
        return $user->projects()->where('projects.id', $doc->project_id)->exists();
    }

    public function create(User $user)
    {
        return method_exists($user, 'hasPermission') && $user->hasPermission('documents.create');
    }

    public function update(User $user, Document $doc)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('documents.update')) {
            return true;
        }
        return $user->projects()->where('projects.id', $doc->project_id)->exists();
    }

    public function delete(User $user, Document $doc)
    {
        if (method_exists($user, 'hasPermission') && $user->hasPermission('documents.delete')) {
            return true;
        }
        return $user->projects()->where('projects.id', $doc->project_id)->exists();
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

