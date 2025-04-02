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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('transaction_id')->unique();
            $table->string('tracking_code')->unique();
            $table->string('friend_mobile')->nullable();
            $table->string('gateway_name');
            $table->unsignedInteger('plan_id')->default(0);
            $table->json('book_ids');
            $table->double('discount_amount')->default(0);
            $table->double('paid_amount');
            $table->enum('type', ['wallet', 'gift_card', 'book', 'subscription']);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
