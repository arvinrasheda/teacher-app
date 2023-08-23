<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Kriteria;
use App\NilaiGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $countGuru = count(Guru::all());
        return view('dashboard', compact('countGuru'));
    }
}
