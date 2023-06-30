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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->float('capacity');
            $table->float('volume');
            $table->float('max_length');
            $table->boolean('ttk_pass');
            $table->boolean('manipulator');
            $table->float('cost_per_hour');
            $table->time('min_order_time');
            $table->float('cost_outside_mkad');
            $table->boolean('documents_return');
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
        Schema::dropIfExists('transports');
    }
};
