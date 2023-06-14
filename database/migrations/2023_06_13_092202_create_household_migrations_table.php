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
        Schema::create('household_migrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('house_hold_id');
            $table->unsignedBigInteger('from_location_id');
            $table->unsignedBigInteger('to_location_id');
            $table->string('reason_for_migration');
            $table->unsignedBigInteger('initiated_by_chv_id');
            $table->unsignedBigInteger('approved_by_cha_id')->nullable();
            $table->date('date_of_migration');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->foreign('house_hold_id')->references('id')->on('house_holds');
            $table->foreign('from_location_id')->references('id')->on('house_hold_addresses');
            $table->foreign('to_location_id')->references('id')->on('house_hold_addresses');
            $table->foreign('initiated_by_chv_id')->references('id')->on('house_hold_person_details');
            $table->foreign('approved_by_cha_id')->references('id')->on('house_hold_person_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_migrations');
    }
};
