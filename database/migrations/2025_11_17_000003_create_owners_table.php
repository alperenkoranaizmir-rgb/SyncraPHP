<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('tc_no')->nullable();
            $table->string('father_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_primary')->nullable();
            $table->string('phone_secondary')->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->text('emergency_contact_address')->nullable();
            $table->string('education')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('photo_path')->nullable();
            $table->boolean('disability_flag')->default(false);
            $table->string('disability_type')->nullable();
            $table->string('disability_report_path')->nullable();
            $table->timestamps();
            $table->unique(['project_id','tc_no']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('owners');
    }
};
