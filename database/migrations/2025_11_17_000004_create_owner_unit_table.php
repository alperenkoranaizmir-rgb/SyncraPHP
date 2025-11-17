<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('owner_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->decimal('share_percent', 5, 2)->default(0);
            $table->string('owner_type')->nullable();
            $table->timestamps();
            $table->unique(['owner_id','unit_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('owner_unit');
    }
};
