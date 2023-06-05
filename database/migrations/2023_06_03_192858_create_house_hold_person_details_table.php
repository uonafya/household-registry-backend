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
        Schema::create('household_person_details', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('country');
            $table->string('county_of_birth');
            $table->boolean('is_alive');
            $table->unsignedBigInteger('residence_id');
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('next_of_kin_id');
            $table->unsignedBigInteger('identification_id');
            $table->unsignedBigInteger('household_id');
            $table->timestamps();

            $table->foreign('residence_id')->references('id')->on('residences');
            $table->foreign('contact_id')->references('id')->on('person_contacts');
            $table->foreign('next_of_kin_id')->references('id')->on('person_next_of_kin');
            $table->foreign('identification_id')->references('id')->on('person_identification_types');
            $table->foreign('household_id')->references('id')->on('households');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_person_details');
    }
};
