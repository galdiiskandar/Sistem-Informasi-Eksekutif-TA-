<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBendungansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bendungans', function (Blueprint $table) {
            $table->string('kode_bendungan');
            $table->string('nama_bendungan', 80);
            $table->string('wilayah', 80);
            $table->integer('luas');
            $table->date('tanggal_dibangun');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bendungans');
    }
}
