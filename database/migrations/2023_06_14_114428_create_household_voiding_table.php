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
        Schema::create('household_voiding', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('house_hold_id');
            $table->string('reason_for_voiding');
            $table->date('date_voided');
            $table->unsignedBigInteger('voided_by_id');
            $table->unsignedBigInteger('voiding_appproved_by_id')->nullable();
            $table->boolean('is_voided_approval_status');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();

            $table->foreign('house_hold_id')->references('id')->on('house_hold');
            $table->foreign('voided_by_id')->references('id')->on('house_hold_person_detail');
            $table->foreign('voiding_appproved_by_id')->references('id')->on('house_hold_person_detail');
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
