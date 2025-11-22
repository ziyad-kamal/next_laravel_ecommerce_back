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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 55);
            $table->enum('approve', ['approved', 'pending', 'refused'])->default('pending');
            $table->string('trans_lang', 5);
            $table->foreignId('trans_of')->nullable()->constrained('items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
