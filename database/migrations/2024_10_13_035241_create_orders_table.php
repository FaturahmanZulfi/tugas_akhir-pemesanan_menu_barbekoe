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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->string('customer_name');
            $table->foreignId('menu_id')->references('id')->on('menus');
            $table->integer('qty');
            $table->integer('total_price');
            $table->tinyInteger('table_number');
            $table->foreignId('status_id')->references('id')->on('statuses');
            // field user_id tidak dibuat foreign key karena, user_id bisa dibuat 0(pesanan dibuat pelanggan)
            $table->integer('user_id');
            $table->timestamp('order_time');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
