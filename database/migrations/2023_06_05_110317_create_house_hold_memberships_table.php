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
        Schema::create('house_hold_memberships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('household_person_details_id');
            $table->unsignedBigInteger('household_member_type_id');
            $table->unsignedBigInteger('household_id');
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('household_person_details_id')->references('id')->on('house_hold_person_details')->onDelete('cascade');
            $table->foreign('household_member_type_id')->references('id')->on('household_member_types')->onDelete('cascade');
            $table->foreign('household_id')->references('id')->on('house_holds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_hold_memberships');
    }
};
