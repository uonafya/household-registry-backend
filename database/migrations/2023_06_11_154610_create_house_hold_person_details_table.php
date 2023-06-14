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

            $table->foreign('residence_id')->references('id')->on('residences')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('person_contact_id')->references('id')->on('person_contacts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('person_next_of_kin_id')->references('id')->on('person_next_of_kin')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('person_identifications_id')->references('id')->on('person_identification_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('household_id')->references('id')->on('house_holds')->onDelete('cascade')->onUpdate('cascade');
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
