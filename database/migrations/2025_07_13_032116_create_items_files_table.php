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
        Schema::create('items_files', function (Blueprint $table) {
            $table->id();
            $table->string('path', 150);
            $table->foreignId('item_id')->nullable()->constrained('items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_files');
    }
};
