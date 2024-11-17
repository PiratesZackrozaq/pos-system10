<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id'); // Auto-incrementing primary key
            $table->string('name'); // Name of the product
            $table->text('description')->nullable(); // Description (optional)
            $table->decimal('price', 10, 2); // Product price
            $table->integer('quantity'); // Make sure the quantity column
            $table->string('image')->nullable();
            $table->boolean('status')->default(0);
            $table->unsignedInteger('category_id'); // Foreign key column as unsigned integer
            $table->unsignedInteger('user_id'); // Foreign key column as unsigned integer user
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
