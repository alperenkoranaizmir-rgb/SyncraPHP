<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PersonnelFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PersonnelFileController extends Controller
{
    public function index(User $user)
    {
        return response()->json($user->personnelFiles()->paginate(20));
    }

    public function store(Request $request, User $user)
    {
        $data = $request->validate([
            'dosya_adi' => 'required|string|max:191',
            'dosya_turu' => 'required|string|max:100',
            'file' => 'required|file|max:51200',
        ]);

        $path = $request->file('file')->store('user_'.$user->getKey(), 'personnel');

        $pf = PersonnelFile::create([
            'user_id' => $user->id,
            'dosya_adi' => $data['dosya_adi'],
            'dosya_turu' => $data['dosya_turu'],
            'dosya_yolu' => $path,
            'yukleyen_id' => $request->user()?->id,
            'yuklenme_tarihi' => now(),
        ]);

        return response()->json($pf,201);
    }

    public function show(PersonnelFile $personel_dosyalari)
    {
        // return download URL
        $path = $personel_dosyalari->dosya_yolu;
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('personnel');
        if ($disk->exists($path)) {
            return $disk->download($path);
        }
        return response()->json(['message'=>'Not found'],404);
    }

    public function destroy(PersonnelFile $personel_dosyalari)
    {
        if (Storage::disk('personnel')->exists($personel_dosyalari->dosya_yolu)) {
            Storage::disk('personnel')->delete($personel_dosyalari->dosya_yolu);
        }
        $personel_dosyalari->delete();
        return response()->noContent();
    }
}
