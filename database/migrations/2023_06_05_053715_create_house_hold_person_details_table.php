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
        Schema::create('house_hold_person_details', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('country');
            $table->string('county_of_birth');
            $table->boolean('is_alive');
            $table->string('residence_id');
            $table->string('contact_id');
            $table->string('next_of_kin_id');
            $table->string('identification_id');
            $table->string('household_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_hold_person_details');
    }
};
