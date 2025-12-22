<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('logs', function (Blueprint $table) {
      $table->bigIncrements('log_id');
      $table->unsignedBigInteger('user_id');
      $table->string('action');
      $table->dateTime('DateTime');
      $table->timestamps();

      $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
      $table->index(['user_id','DateTime']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('logs');
  }
};
