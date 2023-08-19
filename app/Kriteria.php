<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria';


    public function nilaiKriteria()
    {
        return $this->hasMany(NilaiKriteria::class, 'kode_kriteria');
    }
}
