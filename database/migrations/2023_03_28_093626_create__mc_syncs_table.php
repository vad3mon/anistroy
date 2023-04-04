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
        Schema::create('mc_syncs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['product_folder', 'product', 'getOrders', 'postOrders', 'clean']);
            $table->integer('offset');
            $table->integer('resultSize');
            $table->integer('size');
            $table->tinyText('result');
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
        Schema::dropIfExists('mc_syncs');
    }
};
