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
        Schema::create('house_hold_membership', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('household_person_details_id');
            $table->unsignedBigInteger('household_member_type_id');
            $table->unsignedBigInteger('household_id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();

            // Define foreign key constraints
            $table->foreign('household_person_details_id')->references('id')->on('house_hold_person_detail')->onUpdate('cascade');
            $table->foreign('household_member_type_id')->references('id')->on('household_member_type')->onUpdate('cascade');
            $table->foreign('household_id')->references('id')->on('house_hold')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_hold_membership');
    }
};
