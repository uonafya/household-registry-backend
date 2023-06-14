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
        Schema::table('house_holds', function (Blueprint $table) {
            $table->boolean('is_muted')->default(false);
            $table->boolean('is_voided')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('house_holds', function (Blueprint $table) {
            $table->dropColumn('is_muted');
            $table->dropColumn('is_voided');
        });
    }
};
