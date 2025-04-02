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
        Schema::create('headlines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->string('title');
            $table->string('time');
            $table->mediumText('file');
            $table->unsignedSmallInteger('order_number')->default(1);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headlines');
    }
};
