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
            $table->foreign('user_id') // Reference category_id column
                  ->references('user_id')->on('users') // Foreign key to categories.id
                  ->onUpdate('restrict') // Cascade updates
                  ->onDelete('restrict'); // Cascade deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key
        });
    }
};
