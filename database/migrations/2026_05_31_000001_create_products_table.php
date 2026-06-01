<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('category');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->integer('stock')->default(0);
            $table->string('badge')->nullable();
            $table->string('badge_class')->default('neutral');
            $table->string('icon')->default('inventory_2');
            $table->integer('sales_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
