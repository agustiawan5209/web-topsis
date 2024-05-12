<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Support\Facades\Request;

class PenilaianController extends Controller
{
    public function index()
    {

        $topsis = $this->Topsis();
        return Inertia::render('Admin/Penilaian/Index', [
            'alternatif' => Alternatif::with(['penilaians'])->filter(Request::only('search'))->get(),
            'kriteria' => Kriteria::all(),
            'topsis' => $topsis,
        ]);
    }
    public function indexUser()
    {

        $topsis = $this->Topsis();
        return Inertia::render('User/Penilaian/Index', [
            'alternatif' => Alternatif::with(['penilaians'])->filter(Request::only('search'))->get(),
            'kriteria' => Kriteria::all(),
            'topsis' => $topsis,
        ]);
    }

    public function Topsis()
    {
        $alternatif = Alternatif::with(['penilaians', 'penilaians.kriteria'])->filter(Request::only('search'))->get();
        $kriteria = Kriteria::all();

        $matrix_alternatif = [];
        $matrix_kriteria = [];
        $matrix_bobot = [];
        if ($alternatif->count() > 2) {
            foreach ($alternatif as $key => $item) {
                $matrix_alternatif[$key]['nama'] = $item->nama;
                foreach ($item->penilaians as $col) {
                    $matrix_alternatif[$key][$col->kriteria->nama] = $col->nilai;
                }
            }
            foreach ($kriteria as $key => $item) {
                $matrix_kriteria[$key] = $item->nama;
                $matrix_bobot[$key] = $item->bobot;
            }
            // dd($matrix_alternatif,$matrix_kriteria, $matrix_bobot);
            $topsis = new TopsisController($matrix_alternatif, $matrix_kriteria, $matrix_bobot);
            // dd($topsis->calculate());
            return $topsis->calculate();
        } else {
            return [];
        }
    }
}
