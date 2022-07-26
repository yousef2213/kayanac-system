<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoldInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // 'id', 'namear', 'nameen','taxRate','quantityM','nature','groupItem','priceWithTax','description','img','price','catId','total','customerId','netTotal','invoiceId','unitId','status'

    public function up()
    {
        Schema::create('hold_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('itemId')->length(11)->unsigned();
            $table->integer('catId')->length(11)->unsigned();
            $table->string('quantityM',100);
            $table->string('namear',255);
            $table->string('nameen',255);
            $table->string('nature',100);
            $table->string('groupItem',100);
            $table->double('priceWithTax');
            $table->string('description',255);
            $table->string('img',255);
            $table->double('price');
            $table->double('total');
            $table->integer('customerId')->length(11)->unsigned();
            $table->double('netTotal');
            $table->integer('invoiceId')->length(11)->unsigned();
            $table->float('qtn');
            $table->string('taxRate',255);

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
        Schema::dropIfExists('hold_invoices');
    }
}
