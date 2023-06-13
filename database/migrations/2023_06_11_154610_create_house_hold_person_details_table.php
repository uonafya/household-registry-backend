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
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('lastName');
            $table->date('dateOfBirth');
            $table->string('gender');
            $table->string('country');
            $table->string('countyOfBirth');
            $table->unsignedBigInteger('residence_id');
            $table->unsignedBigInteger('person_contact_id');
            $table->unsignedBigInteger('person_next_of_kin_id');
            $table->unsignedBigInteger('person_identifications_id');
            $table->boolean('is_alive');
            $table->unsignedBigInteger('household_id');
            $table->timestamps();

            $table->foreign('residence_id')->references('id')->on('residences');
            $table->foreign('person_contact_id')->references('id')->on('person_contacts');
            $table->foreign('person_next_of_kin_id')->references('id')->on('person_next_of_kin');
            $table->foreign('person_identifications_id')->references('id')->on('person_identification_types');
            $table->foreign('household_id')->references('id')->on('house_holds');
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
