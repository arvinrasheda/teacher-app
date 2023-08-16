<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_kriteria', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_kriteria', 16);
            $table->string('keterangan', 256);
            $table->double('nilai');
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
        Schema::dropIfExists('nilai_kriteria');
    }
}
