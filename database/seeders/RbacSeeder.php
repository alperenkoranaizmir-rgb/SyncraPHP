<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RbacSeeder extends Seeder
{
    public function run()
    {
        // Insert sample permissions and roles if tables exist
        if (Schema::hasTable('roles') && Schema::hasTable('permissions')) {
            $permissions = [
                ['name' => 'projects.viewAny', 'label' => 'View any project'],
                ['name' => 'projects.view', 'label' => 'View project'],
                ['name' => 'projects.create', 'label' => 'Create project'],
                ['name' => 'units.manage', 'label' => 'Manage units'],
                ['name' => 'owners.manage', 'label' => 'Manage owners'],
                ['name' => 'decisions.manage', 'label' => 'Manage decisions'],
            ];

            foreach ($permissions as $p) {
                DB::table('permissions')->updateOrInsert(['name' => $p['name']], $p);
            }

            // create admin role
            $adminRoleId = DB::table('roles')->updateOrInsert(['name' => 'admin'], ['name' => 'admin', 'label' => 'Administrator']);

            // attach all permissions to admin role if pivot exists
            if (Schema::hasTable('permission_role')) {
                $permIds = DB::table('permissions')->pluck('id')->toArray();
                foreach ($permIds as $pid) {
                    DB::table('permission_role')->updateOrInsert(['permission_id' => $pid, 'role_id' => is_array($adminRoleId) ? $adminRoleId['id'] ?? null : $adminRoleId]);
                }
            }

            // attach admin role to first user if user_role table exists
            if (Schema::hasTable('user_role')) {
                $firstUser = DB::table('users')->first();
                if ($firstUser) {
                    $role = DB::table('roles')->where('name', 'admin')->first();
                    if ($role) {
                        DB::table('user_role')->updateOrInsert(['user_id' => $firstUser->id, 'role_id' => $role->id], ['user_id' => $firstUser->id, 'role_id' => $role->id]);
                    }
                }
            }
        }

        // Fallback: if no structured RBAC tables, create a simple seed in 'roles' and 'user_role' if present
        if (Schema::hasTable('roller') && Schema::hasTable('user_role')) {
            DB::table('roller')->updateOrInsert(['rol_adi' => 'admin'], ['rol_adi' => 'admin', 'aciklama' => 'Yönetici']);
            $firstUser = DB::table('users')->first();
            $role = DB::table('roller')->where('rol_adi', 'admin')->first();
            if ($firstUser && $role) {
                DB::table('user_role')->updateOrInsert(['user_id' => $firstUser->id, 'rol_id' => $role->id], ['user_id' => $firstUser->id, 'rol_id' => $role->id]);
            }
        }
    }
}
