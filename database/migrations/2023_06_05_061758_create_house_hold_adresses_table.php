<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('house_hold_adresses', function (Blueprint $table) {
            $table->id();
            $table->string('household_type_id');
            $table->string('area_type_id');
            $table->string('area_name');
            $table->string('area_code');
            $table->string('parent_area_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_hold_adresses');
    }
};
