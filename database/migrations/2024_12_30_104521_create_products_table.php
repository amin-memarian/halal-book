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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translator_id')->nullable()->references('id')->on('authors')->cascadeOnDelete();
            $table->foreignId('publisher_id')->references('id')->on('publishers')->cascadeOnDelete();
            $table->foreignId('speaker_id')->references('id')->on('authors')->cascadeOnDelete();
            $table->string('name');
            $table->string('isbn', 69)->nullable();
            $table->mediumText('image');
            $table->integer('number_of_pages')->unsigned()->nullable();
            $table->string('time', 30)->nullable();
            $table->unsignedDouble('pdf_file_size')->nullable();
            $table->smallInteger('publish_year')->unsigned()->nullable();
            $table->bigInteger('price')->unsigned();
            $table->bigInteger('discount_price')->unsigned()->nullable();
            $table->text('content');
            $table->enum('type', ['audio', 'text']);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnDelete();
        });

        Schema::create('author_product', function (Blueprint $table) {
            $table->foreignId('author_id')->references('id')->on('authors')->cascadeOnDelete();
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
