<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->string('cashier');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('member_name')->nullable();
            $table->integer('total');
            $table->integer('items_count')->default(1);
            $table->enum('status', ['Paid', 'Pending', 'Cancelled'])->default('Paid');
            $table->string('status_class')->default('success');
            $table->timestamp('transacted_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_transactions');
    }
};
