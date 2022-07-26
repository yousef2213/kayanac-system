<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumOrdersTable extends Migration {

    public function up() {
        Schema::create('num_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('num')->length(11)->unsigned();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('num_orders');
    }
}
