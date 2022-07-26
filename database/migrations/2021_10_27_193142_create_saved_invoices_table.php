<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('itemId')->nullable()->length(11)->unsigned();
            $table->integer('status')->default(1)->length(11)->unsigned();
            $table->integer('unitId')->default(1)->length(11)->unsigned();
            $table->integer('invoiceId')->nullable()->length(11)->unsigned();
            $table->integer('catId')->nullable()->length(11)->unsigned();
            $table->string('quantityM',100)->nullable();;
            $table->string('namear',255)->nullable();
            $table->string('nameen',255)->nullable();
            $table->string('nature',100)->nullable();
            $table->integer('groupItem')->nullable()->length(11)->unsigned();
            $table->double('priceWithTax')->default(0);
            $table->string('description',255)->nullable();
            $table->string('img',255)->nullable();
            $table->double('price')->default(0);
            $table->double('total')->default(0);
            $table->integer('customerId')->default(1)->length(11)->unsigned();
            $table->double('netTotal')->default(0);
            $table->float('qtn')->default(1);
            $table->string('taxRate',255)->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_invoices');
    }
}
