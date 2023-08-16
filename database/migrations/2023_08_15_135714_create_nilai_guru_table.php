<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_guru', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip_guru', 16);
            $table->string('kode_kriteria', 16);
            $table->unsignedBigInteger('id_nilai_kriteria');
            // Tambahkan kolom lain yang diperlukan
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
        Schema::dropIfExists('nilai_guru');
    }
}
