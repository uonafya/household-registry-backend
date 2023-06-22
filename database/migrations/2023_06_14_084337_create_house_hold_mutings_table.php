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
        Schema::create('house_hold_muting', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('house_hold_id');
            $table->string('reason_for_muting');
            $table->date('date_muted');
            $table->unsignedBigInteger('muted_by_id');
            $table->unsignedBigInteger('muting_appproved_by_id')->nullable();
            $table->boolean('is_muted_approval_status');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            $table->foreign('house_hold_id')->references('id')->on('house_hold');
            $table->foreign('muted_by_id')->references('id')->on('house_hold_person_detail');
            $table->foreign('muting_appproved_by_id')->references('id')->on('house_hold_person_detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_hold_mutings');
    }
};
