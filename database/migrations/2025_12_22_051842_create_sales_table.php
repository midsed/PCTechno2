<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('sales', function (Blueprint $table) {
      $table->bigIncrements('sales_id');
      $table->unsignedBigInteger('transaction_id');
      $table->decimal('total_amount', 10, 2);
      $table->enum('payment_method', ['Cash','Credit Card','GCash','PayMaya'])->default('Cash');
      $table->dateTime('sales_date');
      $table->timestamps();

      $table->foreign('transaction_id')->references('transaction_id')->on('transactions')->cascadeOnDelete();
      $table->index(['sales_date']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('sales');
  }
};
