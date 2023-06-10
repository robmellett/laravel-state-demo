<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->decimal('amount', 8, 2);
            $table->decimal('balance', 8, 2);
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gift_cards');
    }
};
