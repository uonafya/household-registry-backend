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
        Schema::table('house_holds', function (Blueprint $table) {
            $table->unsignedBigInteger('household_approved_by_id')->nullable();
            $table->unsignedBigInteger('household_registered_by_id');

            $table->foreign('household_approved_by_id')->references('id')->on('house_hold_person_details')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('household_registered_by_id')->references('id')->on('house_hold_person_details')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('house_holds', function (Blueprint $table) {
            //
        });
    }
};
