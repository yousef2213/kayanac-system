<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->integer('code')->nullable()->length(11)->unsigned();
            $table->string('name',255)->unique();
            $table->integer('group')->nullable()->length(11)->unsigned();
            $table->string('address',255)->nullable();
            $table->string('phone',100)->nullable();
            $table->string('VATRegistration',50)->nullable();
            $table->string('IdentificationNumber',50)->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
