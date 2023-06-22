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
        Schema::create('administrative_hierachy', function (Blueprint $table) {
            $table->id();
            $table->string('hierarchy_name',20);
            $table->string('code',10);
            $table->string('facility',50);
            $table->string('status',20);
            $table->string('house_holds',20);
            $table->date('date_established');
            $table->string('location',20);
            $table->boolean('isClosed');
            $table->boolean('isRejected');
            $table->string('number_of_chvs',20);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->string('updated_by',50)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_hierachy');
    }
};
