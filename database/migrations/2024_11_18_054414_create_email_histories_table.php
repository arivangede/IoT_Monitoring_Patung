<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('email_receiver_id');
            $table->foreign('email_receiver_id')->references('id')->on('email_receivers')->onDelete('cascade');
            $table->string('title');
            $table->string('text');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_histories');
    }
};