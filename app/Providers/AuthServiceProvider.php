<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Project;
use App\Models\Unit;
use App\Models\Owner;
use App\Models\Document;
use App\Models\Decision;
use App\Policies\ProjectPolicy;
use App\Policies\UnitPolicy;
use App\Policies\OwnerPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\DecisionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // register policies
        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Unit::class, UnitPolicy::class);
        Gate::policy(Owner::class, OwnerPolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);
        Gate::policy(Decision::class, DecisionPolicy::class);

        // RBAC: if user has a permission named like the ability, allow it
        Gate::before(function ($user, $ability) {
            if (method_exists($user, 'hasPermission') && $user->hasPermission($ability)) {
                return true;
            }
        });
    }
}
