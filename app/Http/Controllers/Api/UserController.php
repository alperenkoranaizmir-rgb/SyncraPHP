<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function($q) use ($s) {
                $q->where('ad','like','%'.$s.'%')
                  ->orWhere('soyad','like','%'.$s.'%')
                  ->orWhere('tc_kimlik_no','like','%'.$s.'%')
                  ->orWhere('email','like','%'.$s.'%');
            });
        }

        if ($request->has('aktif')) {
            $query->where('aktif', (bool)$request->input('aktif'));
        }

        $users = $query->paginate(20);

        return response()->json($users);
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('profil_resmi')) {
            $path = $request->file('profil_resmi')->store('avatars','personnel');
            $data['profil_resmi'] = $path;
        }

        $user = User::create($data);

        if ($request->filled('roles')) {
            $roles = Role::whereIn('rol_adi', $request->input('roles'))->get();
            $user->roles()->sync($roles->pluck('id')->toArray());
        }

        if ($request->filled('groups')) {
            $groups = Group::whereIn('grup_adi', $request->input('groups'))->get();
            $user->groups()->sync($groups->pluck('id')->toArray());
        }

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        $user->load(['roles','groups','projects','personnelFiles']);
        return response()->json($user);
    }

    public function update(StoreUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('profil_resmi')) {
            $path = $request->file('profil_resmi')->store('avatars','personnel');
            $data['profil_resmi'] = $path;
        }

        $user->update($data);

        if ($request->filled('roles')) {
            $roles = Role::whereIn('rol_adi', $request->input('roles'))->get();
            $user->roles()->sync($roles->pluck('id')->toArray());
        }

        if ($request->filled('groups')) {
            $groups = Group::whereIn('grup_adi', $request->input('groups'))->get();
            $user->groups()->sync($groups->pluck('id')->toArray());
        }

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    public function roles(User $user)
    {
        return response()->json($user->roles);
    }

    public function addRole(Request $request, User $user)
    {
        $rolAdi = $request->input('rol_adi');
        $role = Role::where('rol_adi',$rolAdi)->firstOrFail();
        $user->roles()->attach($role->id);
        return response()->json(['ok'=>true]);
    }

    public function addGroup(Request $request, User $user)
    {
        $grupAdi = $request->input('grup_adi');
        $group = Group::where('grup_adi',$grupAdi)->firstOrFail();
        $user->groups()->attach($group->id);
        return response()->json(['ok'=>true]);
    }

    public function projects(User $user)
    {
        return response()->json($user->projects()->get());
    }
}
