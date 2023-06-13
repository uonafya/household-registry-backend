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
            $table->unsignedBigInteger('household_type_id');
            $table->unsignedBigInteger('household_address_id');
            $table->timestamps();

            $table->foreign('household_type_id')->references('id')->on('house_hold_types');
            $table->foreign('household_address_id')->references('id')->on('house_hold_addresses');

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
