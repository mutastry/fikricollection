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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('songket_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->string('selected_color')->nullable();
            $table->decimal('price', 12, 2);
            $table->timestamps();

            $table->index(['user_id', 'songket_id']);
            $table->unique(['user_id', 'songket_id', 'selected_color'], 'cart_items_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
