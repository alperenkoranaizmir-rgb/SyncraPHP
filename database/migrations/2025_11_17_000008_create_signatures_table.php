<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('decision_id')->constrained('decisions')->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->boolean('signed')->default(false);
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();
            $table->unique(['decision_id','owner_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('signatures');
    }
};
