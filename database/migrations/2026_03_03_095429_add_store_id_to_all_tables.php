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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()->after('supplier_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::table('recepies', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
