<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('block')->nullable();
            $table->string('ada')->nullable();
            $table->string('parsel')->nullable();
            $table->string('unit_no')->nullable();
            $table->string('unit_type')->nullable();
            $table->string('floor')->nullable();
            $table->string('interior_door_no')->nullable();
            $table->string('exterior_door_no')->nullable();
            $table->decimal('area_m2', 10, 2)->nullable();
            $table->unsignedInteger('arsa_payi_num')->nullable();
            $table->unsignedInteger('arsa_payi_den')->nullable();
            $table->string('tapu_cilt_no')->nullable();
            $table->string('tapu_sayfa_no')->nullable();
            $table->string('edinme_sebebi')->nullable();
            $table->date('edinme_tarihi')->nullable();
            $table->boolean('tapu_haciz')->default(false);
            $table->json('tapu_raw_json')->nullable();
            $table->string('usage_status')->nullable();
            $table->timestamps();
            $table->index(['project_id','unit_no']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('units');
    }
};
