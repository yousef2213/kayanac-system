<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->longText('namear',255);
            $table->string('nameen',255)->nullable();
            $table->string('img',255)->nullable();
            $table->string('catId',255)->default(1);
            $table->integer('taxRate')->default(0)->length(11)->unsigned();;
            $table->string('quantityM',255)->nullable();
            $table->string('nature',100)->nullable();
            $table->string('group',255);
            $table->integer('priceWithTax')->nullable()->length(11)->unsigned();;
            $table->string('description',255)->nullable();
            $table->integer('active')->default(1)->length(11)->unsigned();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
