<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('order_items_id'); // Auto-increment ID
            $table->unsignedInteger('order_id'); // Foreign key to the orders table
            $table->unsignedInteger('product_id'); // Foreign key to the products table
            $table->decimal('price', 10, 2); // Price of the product in the order
            $table->integer('quantity'); // Quantity of the product in the order
            $table->timestamps(); // Automatically includes created_at and updated_at columns

            // Foreign keys
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
