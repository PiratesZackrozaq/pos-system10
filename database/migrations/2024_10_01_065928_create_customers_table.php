<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('customer_id'); // Automatically sets the primary key with 'id'
            $table->string('name'); // 'name' varchar(255) NOT NULL
            $table->string('email')->nullable(); // 'email' varchar(255) DEFAULT NULL
            $table->string('phone')->nullable(); // 'phone' varchar(255) DEFAULT NULL
            $table->tinyInteger('status')->default(0)->comment('0=visible,1=hidden'); // 'status' tinyint(1) NOT NULL DEFAULT 0
            $table->unsignedInteger('user_id')->nullable(); // Foreign key column as unsigned integer
            $table->timestamp('created_at')->useCurrent(); // 'created_at' date NOT NULL DEFAULT current_timestamp()
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
