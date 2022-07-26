<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('namear',255)->unique();
            $table->string('nameen',255);
            $table->integer('companyId')->length(11)->unsigned();
            $table->string('city',255)->nullable();
            $table->string('address',255)->nullable();
            $table->string('region',255)->nullable();
            $table->string('country',255)->nullable();
            $table->string('phone',255)->unique()->nullable();
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
        Schema::dropIfExists('branches');
    }
}
