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
        Schema::create('warehouse_movements', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['production', 'stock_in', 'stock_out', 'order', 'supplier_return', 'customer_return', 'adjustment', 'inventory_count']); // produzione, carico, scarico ecc.
            $table->integer('quantity')->nullable();
            $table->foreignId('recepy_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_movements');
    }
};
