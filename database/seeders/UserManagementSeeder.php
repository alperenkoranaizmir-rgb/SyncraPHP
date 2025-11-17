<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class UserManagementSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['rol_adi'=>'admin','rol_aciklama'=>'Sistem yöneticisi','aktif'=>true],
            ['rol_adi'=>'proje_yoneticisi','rol_aciklama'=>'Proje yöneticisi','aktif'=>true],
            ['rol_adi'=>'personel','rol_aciklama'=>'Normal personel','aktif'=>true],
        ];

        foreach ($roles as $r) {
            Role::updateOrCreate(['rol_adi'=>$r['rol_adi']], $r);
        }

        $perms = [
            ['izin_adi'=>'kullanici.create','aciklama'=>'Kullanıcı oluştur'],
            ['izin_adi'=>'kullanici.update','aciklama'=>'Kullanıcı güncelle'],
            ['izin_adi'=>'kullanici.delete','aciklama'=>'Kullanıcı sil'],
            ['izin_adi'=>'grup.yonetim','aciklama'=>'Grupları yönet'],
            ['izin_adi'=>'proje.yonetim','aciklama'=>'Projeleri yönet'],
        ];

        foreach ($perms as $p) {
            Permission::updateOrCreate(['izin_adi'=>$p['izin_adi']], $p);
        }

        // Attach some permissions to admin
        $admin = Role::where('rol_adi','admin')->first();
        if ($admin) {
            $all = Permission::pluck('id')->toArray();
            $admin->permissions()->sync($all);
        }
    }
}
