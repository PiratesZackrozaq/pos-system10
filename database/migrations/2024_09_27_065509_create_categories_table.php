<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('category_id'); // Auto-incrementing primary key
            $table->string('name'); // Name of the category
            $table->text('description')->nullable(); // Description (optional)
            $table->boolean('status')->default(0); // Adds 'status'
            $table->unsignedInteger('user_id')->nullable(); // Foreign key column as unsigned integer
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
