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
        Schema::create('household_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('household_type_name');
            $table->string('area_type_id');
            $table->string('area_name');
            $table->string('area_code');
            $table->unsignedBigInteger('parent_area_id')->nullable();
            $table->unsignedBigInteger('household_id');
            $table->timestamps();

            $table->foreign('parent_area_id')->references('id')->on('household_addresses');
            $table->foreign('household_id')->references('id')->on('households');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_addresses');
    }
};
