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
            $table->string('code');
            $table->foreignid('user_id')->references('id')->on('users');
            $table->foreignid('staff_id')->nullable()->references('id')->on('users');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->integer('quantity')->nullable();
            $table->integer('before');
            $table->integer('after');
            $table->integer('method');
            $table->string('review')->nullable();
            $table->string('address')->nullable();
            $table->integer('status')->default(0);
            $table->integer('total')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
