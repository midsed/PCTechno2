<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('products', function (Blueprint $table) {
      $table->bigIncrements('product_id');
      $table->string('product_name');
      $table->text('description')->nullable();
      $table->decimal('price', 10, 2);
      $table->unsignedInteger('quantity_available')->default(0);
      $table->boolean('is_archived')->default(false);
      $table->timestamps();

      $table->index(['is_archived','quantity_available']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('products');
  }
};
