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
            $table->foreign('order_id') // Reference category_id column
                  ->references('order_id')->on('orders') // Foreign key to categories.id
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
            $table->dropForeign(['order_id']); // Drop the foreign key
        });
    }
};
