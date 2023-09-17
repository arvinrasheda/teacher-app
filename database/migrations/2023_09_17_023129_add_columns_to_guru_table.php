<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->string('posisi', 10)->nullable()->after('nama');
            $table->string('jenis_kelamin', 1)->nullable()->after('posisi');
            $table->integer('masa_bakti')->nullable()->after('jenis_kelamin');
            $table->string('pendidikan', 2)->nullable()->after('masa_bakti');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guru', function (Blueprint $table) {
            Schema::table('guru', function (Blueprint $table) {
                $table->dropColumn('posisi');
                $table->dropColumn('jenis_kelamin');
                $table->dropColumn('masa_bakti');
                $table->dropColumn('pendidikan');
            });
        });
    }
}
