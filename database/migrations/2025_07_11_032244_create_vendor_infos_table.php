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
        Schema::create('vendor_infos', function (Blueprint $table) {
            $table->id();
            $table->string('address', 150);
            $table->bigInteger('phone', false, true);
            $table->string('card_type', 30)->nullable();
            $table->bigInteger('card_num', 150)->nullable();
            $table->tinyInteger('csv', false, true)->nullable();
            $table->timestamp('card_exp_date', 150)->nullable();
            $table->string('card_name', 50)->nullable();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_infos');
    }
};
