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
        Schema::create('person_next_of_kin', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('relationship');
            $table->string('residence');
            $table->unsignedBigInteger('contact_id');
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('contact_id')->references('id')->on('person_contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_next_of_kin');
    }
};
