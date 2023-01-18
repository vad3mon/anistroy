<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->nullable();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->bigInteger('article')->unsigned()->unique();
            $table->string('unit', 80);
            $table->string('image', 70)->nullable();
            $table->decimal('price', 10, 2, true)->default(0);
            $table->decimal('old_price', 10, 2, true)->default(0);
            $table->text('text');
            $table->string('properties')->nullable();
            $table->smallInteger('weight')->unsigned();
            $table->smallInteger('volume')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
