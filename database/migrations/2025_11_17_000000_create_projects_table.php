<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('location_json')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->default('draft');
            $table->unsignedInteger('total_units')->default(0);
            $table->decimal('total_m2', 12, 2)->nullable();
            $table->decimal('construction_area', 12, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('est_end_date')->nullable();
            $table->decimal('est_budget', 16, 2)->nullable();
            $table->decimal('emsal_ratio', 6, 3)->nullable();
            $table->json('photos')->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
