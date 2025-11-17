<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return response()->json(Group::paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'grup_adi' => 'required|string|max:191',
            'aciklama' => 'nullable|string',
            'aktif' => 'boolean'
        ]);

        $g = Group::create($data);
        return response()->json($g,201);
    }

    public function show(Group $grup)
    {
        $grup->load('users');
        return response()->json($grup);
    }

    public function update(Request $request, Group $grup)
    {
        $data = $request->validate([
            'grup_adi' => 'required|string|max:191',
            'aciklama' => 'nullable|string',
            'aktif' => 'boolean'
        ]);
        $grup->update($data);
        return response()->json($grup);
    }

    public function destroy(Group $grup)
    {
        $grup->delete();
        return response()->noContent();
    }
}
