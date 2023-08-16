<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 16)->primary();
            $table->string('nama_kriteria', 256);
            $table->string('atribut', 16);
            $table->double('Bobot');
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
        Schema::dropIfExists('kriteria');
    }
}
