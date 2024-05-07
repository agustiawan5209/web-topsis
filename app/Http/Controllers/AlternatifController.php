<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreAlternatifRequest;
use App\Http\Requests\UpdateAlternatifRequest;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'alternatif'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        //
        return Inertia::render('Admin/Alternatif/Index', [
            'search' =>  Request::input('search'),
            'table_colums'=> array_values(array_diff($columns, ['remember_token','password', 'email_verified_at', 'created_at', 'updated_at'])),
            'data'=> Alternatif::filter(Request::only('search','order'))->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Alternatif/Create', [
            'kriteria'=> Kriteria::with(['sub_kriteria'])->get(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlternatifRequest $request)
    {

        return redirect()->route('Alternatif.index')->with('message', 'Data Alternatif Berhasil Di Tambah!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alternatif $alternatif)
    {
        return Inertia::render('Admin/Alternatif/Show', [
            'alternatif'=> $alternatif->with(['penilaians'])->find(Request::input('slug')),
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alternatif $alternatif)
    {
        return Inertia::render('Admin/Alternatif/Edit', [
            'alternatif'=> $alternatif->with(['penilaians'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlternatifRequest $request, Alternatif $alternatif)
    {
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
