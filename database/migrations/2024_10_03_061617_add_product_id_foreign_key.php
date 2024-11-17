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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('product_id') // Reference category_id column
                  ->references('product_id')->on('products') // Foreign key to categories.id
                  ->onUpdate('restrict') // Cascade updates
                  ->onDelete('restrict'); // Cascade deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']); // Drop the foreign key
        });
    }
};
