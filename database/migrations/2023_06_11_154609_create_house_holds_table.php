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
        Schema::create('house_hold', function (Blueprint $table) {
            $table->id();
            $table->string('household_name', 100);
            $table->string('household_identifier', 100);
            $table->unsignedBigInteger('household_type_id')->nullable();
            $table->unsignedBigInteger('household_address_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        
            $table->foreign('household_type_id')->references('id')->on('house_hold_type')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('household_address_id')->references('id')->on('house_hold_address')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_holds');
    }
};
