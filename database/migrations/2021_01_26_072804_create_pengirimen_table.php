<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengirimenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pos_id');
            $table->foreign('pos_id')->references('id')->on('pos');
            $table->string('no_register');
            $table->string('status');
            $table->string('pemilik');
            $table->string('alamat_rumah');
            $table->string('alamat_pengirim');
            $table->string('hp');
            $table->string('no_perkara')->nullable();
            $table->string('no_akta')->nullable();
            $table->date('tanggal_akta')->nullable();
            $table->string('resi')->nullable();
            $table->date('tanggal_terkirim')->nullable();
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
        Schema::dropIfExists('pengiriman');
    }
}
