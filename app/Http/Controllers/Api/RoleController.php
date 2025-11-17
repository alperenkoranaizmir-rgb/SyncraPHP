<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return response()->json(Role::paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rol_adi' => 'required|string|max:191',
            'rol_aciklama' => 'nullable|string',
            'aktif' => 'boolean'
        ]);

        $r = Role::create($data);
        return response()->json($r,201);
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return response()->json($role);
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'rol_adi' => 'required|string|max:191',
            'rol_aciklama' => 'nullable|string',
            'aktif' => 'boolean'
        ]);
        $role->update($data);
        return response()->json($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->noContent();
    }
}
