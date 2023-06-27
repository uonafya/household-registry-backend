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
        Schema::create('geo_location', function (Blueprint $table) {
            $table->integer('area_id')->primary();
            $table->string('area_type_id', 50);
            $table->string('area_name', 100);
            $table->string('area_code', 10)->nullable();
            $table->integer('parent_area_id')->nullable();
            $table->string('area_name_abbr', 5)->nullable();
            $table->timestamp('timestamp_created')->useCurrent();
            $table->timestamp('timestamp_updated')->nullable();
            $table->boolean('is_void')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geo_location');
    }
};

