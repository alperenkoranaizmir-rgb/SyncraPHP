<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gruplar', function (Blueprint $table) {
            $table->id();
            $table->string('grup_adi');
            $table->text('aciklama')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('roller', function (Blueprint $table) {
            $table->id();
            $table->string('rol_adi');
            $table->text('rol_aciklama')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('izinler', function (Blueprint $table) {
            $table->id();
            $table->string('izin_adi');
            $table->text('aciklama')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('rol_izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rol_id')->constrained('roller')->cascadeOnDelete();
            $table->foreignId('izin_id')->constrained('izinler')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('rol_id')->constrained('roller')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('user_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('grup_id')->constrained('gruplar')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_group');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('rol_izin');
        Schema::dropIfExists('izinler');
        Schema::dropIfExists('roller');
        Schema::dropIfExists('gruplar');
    }
};
