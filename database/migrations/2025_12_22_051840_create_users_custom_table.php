<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    // Drop default users table if Breeze created it (optional approach)
    // If you already migrated default users, rollback first, or rename.
    Schema::dropIfExists('users');

    Schema::create('users', function (Blueprint $table) {
      $table->bigIncrements('user_id');
      $table->string('full_name');
      $table->enum('role', ['admin','employee','cashier','customer'])->default('customer');
      $table->string('username')->unique();
      $table->string('password'); // hashed
      $table->string('email')->unique();
      $table->rememberToken();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('users');
  }
};
