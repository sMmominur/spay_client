<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSPClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_p_clients', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->string('txt_id');
            $table->string('bank_tx_id')->nullable();
            $table->string('return_url');
            $table->string('instrument')->nullable();
            $table->string('sp_code');
            $table->string('client_ip');
            $table->string('status');
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
        Schema::dropIfExists('s_p_clients');
    }
}
