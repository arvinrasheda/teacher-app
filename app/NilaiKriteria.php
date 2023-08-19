<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiKriteria extends Model
{
    protected $table = 'nilai_kriteria';

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kode_kriteria');
    }
}
