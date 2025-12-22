<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('customers', function (Blueprint $table) {
      $table->bigIncrements('customer_id');
      $table->string('customer_name');
      $table->string('contact_information')->nullable();
      $table->string('address')->nullable();
      $table->boolean('is_archived')->default(false);
      $table->timestamps();

      $table->index(['is_archived','customer_name']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('customers');
  }
};
