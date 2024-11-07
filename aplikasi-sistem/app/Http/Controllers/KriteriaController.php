<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreKriteriaRequest;
use App\Http\Requests\UpdateKriteriaRequest;
use App\Models\SubKriteria;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tableName = 'kriterias'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        //
        return Inertia::render('Admin/Kriteria/Index', [
            'search' =>  Request::input('search'),
            'table_colums'=> array_values(array_diff($columns, ['remember_token','password', 'email_verified_at', 'created_at', 'updated_at'])),
            'data'=> Kriteria::filter(Request::only('search','order'))->paginate(10),
            'can'=> [
                'add'=> false,
                'edit'=> true,
                'show'=> false,
                'delete'=> false,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Kriteria/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKriteriaRequest $request)
    {
        $data = $request->all();

        $arr = $request->namasubkriteria;
        $bobot = $request->bobotsubkriteria;

        $kriteria = Kriteria::create([
            'nama'=> $request->namakriteria,
            'bobot'=> $request->bobot,
        ]);
        for ($i=0; $i < count($arr); $i++) {
            if(isset($arr[$i]) && isset($bobot[$i])){
                SubKriteria::create([
                    'kriteria_id'=> $kriteria->id,
                    'nama'=> $arr[$i],
                    'bobot'=> $bobot[$i],
                ]);
            }
        }

        return redirect()->route('Kriteria.index')->with('message', 'Data Kriteria Berhasil Di Tambah!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriteria)
    {
        return Inertia::render('Admin/Kriteria/Show',[
            'kriteria'=> $kriteria->with(['subKriteria'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kriteria $kriteria)
    {
        return Inertia::render('Admin/Kriteria/Edit',[
            'kriteria'=> $kriteria->with(['subKriteria'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKriteriaRequest $request, Kriteria $kriteria)
    {
        $kriteria = $kriteria->find(Request::input('slug'));
        $kriteria->update($request->all());

        $arr = $request->namasubkriteria;
        $bobot = $request->bobotsubkriteria;

        $subKriteria = SubKriteria::where('kriteria_id', $kriteria->id)->delete();

        for ($i=0; $i < count($arr); $i++) {
            if(isset($arr[$i]) && isset($bobot[$i])){
                SubKriteria::create([
                    'kriteria_id'=> $kriteria->id,
                    'nama'=> $arr[$i],
                    'bobot'=> $bobot[$i],
                ]);
            }
        }
        return redirect()->route('Kriteria.index')->with('message', 'Data Kriteria Berhasil Di Edit!!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kriteria $kriteria)
    {
        $kriteria->find(Request::input('slug'))->delete();
        return redirect()->route('Kriteria.index')->with('message', 'Data Kriteria Berhasil Di Hapus!!');

    }
}
