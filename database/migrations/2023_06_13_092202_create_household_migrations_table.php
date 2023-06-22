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
        Schema::create('household_migration', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('house_hold_id');
            $table->unsignedBigInteger('old_residence_id');
            $table->unsignedBigInteger('new_residence_id');
            $table->string('reason_for_migration');
            $table->unsignedBigInteger('initiated_by_chv_id');
            $table->unsignedBigInteger('approved_by_cha_id')->nullable();
            $table->date('date_of_migration');
            $table->boolean('is_approved')->default(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            $table->foreign('house_hold_id')->references('id')->on('house_hold');
            $table->foreign('old_residence_id')->references('id')->on('house_hold_address');
            $table->foreign('new_residence_id')->references('id')->on('house_hold_address');
            $table->foreign('initiated_by_chv_id')->references('id')->on('house_hold_person_detail');
            $table->foreign('approved_by_cha_id')->references('id')->on('house_hold_person_detail');
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
