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
        Schema::table('warehouse_movements', function (Blueprint $table) {
            // Stato magazzino prima e dopo il movimento
            $table->integer('before_quantity')->after('product_id');
            $table->integer('after_quantity')->after('before_quantity');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warehouse_movements', function (Blueprint $table) {
            
            $table->dropColumn('user_id');
        });
    }
};
