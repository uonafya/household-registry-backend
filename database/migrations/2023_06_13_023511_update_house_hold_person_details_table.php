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
        Schema::table('house_hold_person_details', function (Blueprint $table) {
            $table->renameColumn('household_id', 'house_hold_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('house_hold_person_details', function (Blueprint $table) {
            $table->renameColumn('house_hold_id', 'household_id');
        });
    }
};
