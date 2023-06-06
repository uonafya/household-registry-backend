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
        Schema::create('house_holds', function (Blueprint $table) {
            $table->id();
            $table->string('household_name');
            $table->string('household_identifier');
            $table->string('household_type_id');
            $table->string('household_address_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_holds');
    }
};
