<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompainesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compaines', function (Blueprint $table) {
            $table->id();
            $table->integer('restaurant')->default(0);
            $table->string('companyNameAr',255);
            $table->string('companyNameEn',255)->nullable();
            $table->string('logo',255)->nullable();
            $table->string('taxNum',255)->default(0);
            $table->string('active',255)->nullable();
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
        Schema::dropIfExists('compaines');
    }
}
