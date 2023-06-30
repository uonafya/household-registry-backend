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
        Schema::create('merged_household', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('household_id_1');
            $table->unsignedBigInteger('household_id_2');
            $table->unsignedBigInteger('merged_household_id')->nullable();
            $table->unsignedBigInteger('initiated_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->boolean('is_appoved')->default(false);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();


            // Define foreign key constraints
            $table->foreign('household_id_1')->references('id')->on('house_hold')->onUpdate('cascade');
            $table->foreign('household_id_2')->references('id')->on('house_hold')->onUpdate('cascade');
            $table->foreign('merged_household_id')->references('id')->on('house_hold')->onUpdate('cascade');
            $table->foreign('initiated_by')->references('id')->on('house_hold_person_detail')->onUpdate('cascade');
            $table->foreign('approved_by')->references('id')->on('house_hold_person_detail')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('house_hold_person_detail')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merged_household');
    }
};
