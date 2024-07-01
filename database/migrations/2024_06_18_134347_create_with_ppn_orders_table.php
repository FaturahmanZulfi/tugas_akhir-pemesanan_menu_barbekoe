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
        Schema::create('with_ppn_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->string('snap_token');
            $table->integer('total_price');
            $table->integer('ppn');
            $table->integer('total_price_with_ppn');
            $table->foreignId('status_id')->references('id')->on('statuses');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('with_ppn_orders');
    }
};
