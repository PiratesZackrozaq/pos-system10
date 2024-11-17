<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id') // Reference category_id column
                  ->references('category_id')->on('categories') // Foreign key to categories.id
                  ->onUpdate('restrict') // Cascade updates
                  ->onDelete('restrict'); // Cascade deletes
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']); // Drop the foreign key
        });
    }
};
