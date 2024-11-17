<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id'); // Auto-increment ID
            $table->unsignedInteger('customer_id'); // Foreign key to the customers table
            $table->string('tracking_no', 100); // Tracking number
            $table->string('invoice_no', 100); // Invoice number
            $table->decimal('total_amount', 10, 2); // Total amount with precision 10,2 (better for currency)
            $table->date('order_date'); // Date of the order
            $table->string('order_status', 100)->nullable(); // Status of the order (nullable)
            $table->string('payment_mode', 100)->comment('cash, online'); // Payment mode
            $table->unsignedInteger('order_placed_by_id'); // User who placed the order (foreign key to users table)
            $table->unsignedInteger('user_id')->nullable(); // User id (foreign key to users table for authenticated users)
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
        Schema::dropIfExists('orders');
    }
}
