<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('cat_id');
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('fabric_id');
            $table->foreign('fabric_id')->references('id')->on('fabric_types')->onDelete('cascade');
            $table->string('productDetalis',200);
            $table->string('width')->defult('75');
            $table->string('height')->defult('180');
            $table->decimal('price',9,2);
            $table->string('discount')->nullable();
            $table->decimal('ThePriceAfterDiscount',9,2)->nullable();
            $table->integer('append')->default('1');
            $table->integer('stock')->default('1');

                // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
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
