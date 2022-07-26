<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemslistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemslists', function (Blueprint $table) {
            $table->id();
            $table->integer('itemId')->default(0)->length(11)->unsigned();
            $table->integer('unitId')->length(11)->unsigned();
            $table->integer('packing')->default(0)->length(11)->unsigned();
            $table->string('barcode',100);
            $table->float('price1')->default(0);
            $table->float('price2')->default(0);
            $table->float('price3')->default(0);
            $table->float('price4')->default(0);
            $table->float('price5')->default(0);
            $table->float('discountAmount')->nullable();
            $table->float('discountPercentage')->nullable();
            $table->float('priceAfterDiscount')->nullable();
            $table->string('qr', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itemslists');
    }
}
