<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PenilaianController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Penilaian/Index', [
            'alternatif'=> Alternatif::with(['penilaians'])->get(),
            'kriteria'=> Kriteria::all(),
        ]);
    }


}
