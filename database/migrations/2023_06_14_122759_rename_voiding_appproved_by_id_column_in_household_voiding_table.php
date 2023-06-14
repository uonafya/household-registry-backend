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
        Schema::table('household_voiding', function (Blueprint $table) {
            $table->renameColumn('voiding_appproved_by_id', 'voiding_approved_by_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('household_voiding', function (Blueprint $table) {
            //
        });
    }
};
