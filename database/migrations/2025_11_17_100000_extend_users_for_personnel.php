<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ad')->nullable();
            $table->string('soyad')->nullable();
            $table->string('tc_kimlik_no')->unique()->nullable();
            $table->date('dogum_tarihi')->nullable();
            $table->enum('cinsiyet', ['erkek','kadın','belirtmek_istemiyor'])->default('belirtmek_istemiyor');
            $table->string('telefon')->nullable();
            $table->string('telefon_ikinci')->nullable();
            $table->text('adres')->nullable();
            $table->string('il')->nullable();
            $table->string('ilce')->nullable();
            $table->string('mahalle')->nullable();
            $table->string('profil_resmi')->nullable();
            $table->string('mezun_oldugu_okul')->nullable();
            $table->string('statu')->nullable();
            $table->string('brans')->nullable();
            $table->string('birim')->nullable();
            $table->string('yetki_seviyesi')->nullable();
            $table->date('is_giris_tarihi')->nullable();
            $table->date('isten_ayrilma_tarihi')->nullable();
            $table->boolean('aktif')->default(true);
            $table->string('acil_durum_kisisi_adi')->nullable();
            $table->string('acil_durum_kisisi_telefon')->nullable();
            $table->string('acil_durum_kisisi_yakinlik')->nullable();
            $table->text('notlar')->nullable();
            // health
            $table->boolean('saglik_engeli_varmi')->default(false);
            $table->string('saglik_raporu')->nullable();
            $table->text('engel_aciklama')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $cols = [
                'ad','soyad','tc_kimlik_no','dogum_tarihi','cinsiyet','telefon','telefon_ikinci','adres','il','ilce','mahalle','profil_resmi','mezun_oldugu_okul','statu','brans','birim','yetki_seviyesi','is_giris_tarihi','isten_ayrilma_tarihi','aktif','acil_durum_kisisi_adi','acil_durum_kisisi_telefon','acil_durum_kisisi_yakinlik','notlar','saglik_engeli_varmi','saglik_raporu','engel_aciklama'
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('users', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
