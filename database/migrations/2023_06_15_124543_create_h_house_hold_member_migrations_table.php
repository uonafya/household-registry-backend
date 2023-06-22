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
        Schema::create('house_hold_member_migration', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hh_member_id');
            $table->unsignedBigInteger('house_hold_id');
            $table->unsignedBigInteger('migration_initiated_by');
            $table->unsignedBigInteger('migration_approved_by');
            $table->string('reason_for_migration');
            $table->boolean('is_migration_approved');
            $table->unsignedBigInteger('new_house_hold_id')->nullable();
            $table->unsignedBigInteger('migrating_from_hous')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_hold_member_migration');
    }
};
