<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('transactions', function (Blueprint $table) {
      $table->bigIncrements('transaction_id');
      $table->unsignedBigInteger('product_id');
      $table->unsignedBigInteger('customer_id')->nullable();
      $table->unsignedInteger('quantity_sold');
      $table->dateTime('transaction_date');
      $table->timestamps();

      $table->foreign('product_id')->references('product_id')->on('products');
      $table->foreign('customer_id')->references('customer_id')->on('customers')->nullOnDelete();
      $table->index(['transaction_date']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('transactions');
  }
};
