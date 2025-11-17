<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('gorev')->nullable();
            $table->date('atanma_tarihi')->nullable();
            $table->timestamps();
        });

        Schema::create('personel_dosyalari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('dosya_adi');
            $table->string('dosya_turu');
            $table->string('dosya_yolu');
            $table->foreignId('yukleyen_id')->nullable()->constrained('users');
            $table->timestamp('yuklenme_tarihi')->useCurrent();
            $table->timestamps();
        });

        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('islem_tipi');
            $table->text('aciklama')->nullable();
            $table->string('ip')->nullable();
            $table->string('tarayici')->nullable();
            $table->timestamp('tarih')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_logs');
        Schema::dropIfExists('personel_dosyalari');
        Schema::dropIfExists('user_project');
    }
};
