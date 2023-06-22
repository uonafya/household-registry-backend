<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('house_hold_person_detail', function (Blueprint $table) {
            $table->id();
            $table->string('nupi_number',50)->nullable();
            $table->string('firstName',50);
            $table->string('middleName',50)->nullable();
            $table->string('lastName',50);
            $table->date('dateOfBirth');
            $table->string('gender',10);
            $table->string('country',20);
            $table->string('countyOfBirth',30);
            $table->unsignedBigInteger('residence_id')->nullable();
            $table->unsignedBigInteger('person_contact_id')->nullable();
            $table->unsignedBigInteger('person_next_of_kin_id')->nullable();
            $table->unsignedBigInteger('person_identifications_id')->nullable();
            $table->boolean('is_alive');
            $table->unsignedBigInteger('household_member_type_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            $table->foreign('residence_id')->references('id')->on('residence')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('person_contact_id')->references('id')->on('person_contact')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('person_next_of_kin_id')->references('id')->on('person_next_of_kin')->onUpdate('cascade');
            $table->foreign('person_identifications_id')->references('id')->on('person_identification_type')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('household_member_type_id')->references('id')->on('household_member_type')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_hold_person_detail');
    }
};
