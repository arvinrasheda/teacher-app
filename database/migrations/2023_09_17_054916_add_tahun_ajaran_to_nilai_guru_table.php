<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTahunAjaranToNilaiGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_guru', function (Blueprint $table) {
            $table->string('tahun_ajaran', 10)->nullable(); // Sesuaikan tipe dan batas yang sesuai
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai_guru', function (Blueprint $table) {
            $table->dropColumn('tahun_ajaran');
        });
    }
}
