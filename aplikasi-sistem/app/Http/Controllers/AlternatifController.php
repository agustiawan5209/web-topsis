<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreAlternatifRequest;
use App\Http\Requests\UpdateAlternatifRequest;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Auth;

class AlternatifController extends Controller
{

    public function Topsis()
    {
        $alternatif = Alternatif::with(['penilaians', 'penilaians.kriteria'])->get();
        $kriteria = Kriteria::all();

        $matrix_alternatif = [];
        $matrix_kriteria = [];
        $matrix_bobot = [];
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
        return [$matrix_alternatif, $matrix_kriteria, $matrix_bobot];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'alternatifs'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        //
        return Inertia::render('Admin/Alternatif/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'user_id', 'password', 'detail', 'email_verified_at', 'created_at', 'updated_at'])),
            'data' => Alternatif::filter(Request::only('search', 'order'))->with(['penilaians'])->paginate(10),
            'kriteria' => Kriteria::all(),
            'ikan' => [
                'Ikan Lele',
                'Ikan Gurame',
                'Ikan Patin',
                'Ikan Mujair',
            ],
            'can' => [
                'add' =>  true,
                'edit' =>  true,
                'show' =>  true,
                'delete' =>  true,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->hasRole('Admin')) {
            return Inertia::render('Admin/Alternatif/Create', [
                'kriteria' => Kriteria::with(['subKriteria'])->get(),
                'ikan' => [
                    'Ikan Lele',
                    'Ikan Gurame',
                    'Ikan Patin',
                    'Ikan Mujair',
                ]
            ]);
        } else {
            return Inertia::render('Admin/Alternatif/Form', [
                'kriteria' => Kriteria::with(['subKriteria'])->get(),
                'ikan' => [
                    'Ikan Lele',
                    'Ikan Gurame',
                    'Ikan Patin',
                    'Ikan Mujair',
                ],
                'alternatif'=> Alternatif::where('user_id', '=',1)->with(['penilaians'])->get(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlternatifRequest $request)
    {
        $ikan =  [
            'Ikan Lele',
            'Ikan Gurame',
            'Ikan Patin',
            'Ikan Mujair',
        ];
        for ($col = 0; $col < count($ikan); $col++) {
            $nama = $ikan[$col];
            $alternatif = Alternatif::create([
                'nama' => $nama,
                'user_id' => Auth::user()->id,
                'detail' => null,
            ]);
            // dd(count($request->penilaian[$col]));
            for ($i = 0; $i < count($request->penilaian[$col]); $i++) {
                $element = $request->penilaian[$col][$i];
                if (isset($element)) {
                    Penilaian::create([
                        'alternatif_id' => $alternatif->id,
                        'kriteria_id' =>  $element['kriteria'],
                        'nilai' =>  $element['nilai'],
                        'nama' =>  $element['nama'],
                    ]);
                }
            }
        }
        return redirect()->route('Alternatif.index')->with('message', 'Data Alternatif Berhasil Di Tambah!!');
    }

        /**
     * Store a newly created resource in storage.
     */
    public function storeForm(StoreAlternatifRequest $request)
    {
        $alternatif = Alternatif::create([
            'nama' => $request->nama,
            'user_id' => Auth::user()->id,
            'detail' => null,
        ]);

        for ($i = 0; $i < count($request->penilaian); $i++) {
            $element = $request->penilaian[$i];
            if (isset($element)) {
                Penilaian::create([
                    'alternatif_id' => $alternatif->id,
                    'kriteria_id' =>  $element['kriteria'],
                    'nilai' =>  $element['nilai'],
                    'nama' =>  $element['nama'],
                ]);
            }
        }
        return redirect()->route('Alternatif.index')->with('message', 'Data Alternatif Berhasil Di Tambah!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alternatif $alternatif)
    {
        return Inertia::render('Admin/Alternatif/Show', [
            'alternatif' => $alternatif->with(['penilaians', "penilaians.kriteria"])->find(Request::input('slug')),
            'kriteria' => Kriteria::with(['subKriteria'])->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alternatif $alternatif)
    {
        return Inertia::render('Admin/Alternatif/Edit', [
            'alternatif' => $alternatif->with(['penilaians'])->find(Request::input('slug')),
            'kriteria' => Kriteria::with(['subKriteria'])->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlternatifRequest $request, Alternatif $alternatif)
    {
        $alternatif = Alternatif::find($request->slug)->update([
            'nama' => $request->nama,
            'detail' => null,
        ]);

        Penilaian::where('alternatif_id', '=', $request->slug)->delete();
        for ($i = 0; $i < count($request->penilaian); $i++) {
            $element = $request->penilaian[$i];

            if (isset($element)) {
                Penilaian::create([
                    'alternatif_id' => $request->slug,
                    'kriteria_id' =>  $element['kriteria'],
                    'nilai' =>  $element['nilai'],
                    'nama' =>  $element['nama'],

                ]);
            }
        }
        return redirect()->route('Alternatif.index')->with('message', 'Data Alternatif Berhasil Di Edit!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alternatif $alternatif)
    {
        $alternatif = $alternatif->with(['penilaians'])->find(Request::input('slug'));
        $alternatif->delete();

        return redirect()->route('Alternatif.index')->with('message', 'Data Alternatif Berhasil Di Hapus!!');
    }
}
