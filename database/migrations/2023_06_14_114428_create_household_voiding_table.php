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
        Schema::create('household_voiding', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('house_hold_id');
            $table->string('reason_for_voiding');
            $table->date('date_voided');
            $table->unsignedBigInteger('voided_by_id');
            $table->unsignedBigInteger('voiding_appproved_by_id')->nullable();
            $table->boolean('is_voided_approval_status');
            $table->timestamps();

            $table->foreign('house_hold_id')->references('id')->on('house_holds')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('voided_by_id')->references('id')->on('house_hold_person_details')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('voiding_appproved_by_id')->references('id')->on('house_hold_person_details')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_voiding');
    }
};
