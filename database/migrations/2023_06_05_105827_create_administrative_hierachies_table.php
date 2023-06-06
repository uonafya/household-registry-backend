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
        Schema::create('administrative_hierachies', function (Blueprint $table) {
            $table->id();
            $table->string('hierarchy_name');
            $table->string('code');
            $table->string('facility');
            $table->string('status');
            $table->string('house_holds');
            $table->date('date_established');
            $table->string('location');
            $table->boolean('isClosed');
            $table->boolean('isRejected');
            $table->string('number_of_chvs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_hierachies');
    }
};
