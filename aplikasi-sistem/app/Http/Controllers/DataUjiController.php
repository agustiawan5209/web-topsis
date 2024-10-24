<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\DataUji;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreDataUjiRequest;
use App\Http\Requests\UpdateDataUjiRequest;

class DataUjiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $tableName = 'data_ujis'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        //
        return Inertia::render('DataUji/Index', [
            'search' =>  Request::input('search'),
            'table_colums'=> array_values(array_diff($columns, ['remember_token','password', 'email_verified_at', 'created_at', 'updated_at'])),
            'penilaian'=> DataUji::filterBySearch(Request::input('search'))
            ->filterByOrder(Request::input('order'))
            ->filterByRole()
            ->filterByDate(Request::input('date'))
            ->paginate(10),
            'can' => [
                'add' =>  false,
                'edit' =>  false,
                'show' =>  false,
                'delete' =>  true,
                'reset' =>  false,

            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDataUjiRequest $request)
    {
        $user = Auth::user();
        $tgl = Carbon::now()->format('Y-m-d');
        $dataUji = DataUji::create([
            'user_id' => $user->id,
            'user' => $user,
            'tgl_uji' => $tgl,
            'hasil' => $request->hasil,
        ]);

        return redirect()->route('Datauji.index')->with('message', 'Data Berhasil Di Simpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataUji $dataUji)
    {
        return Inertia::render('DataUji/Show', [
            'data'=> DataUji::find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataUji $dataUji)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataUjiRequest $request, DataUji $dataUji)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataUji $dataUji)
    {
        $dataUji->find(Request::input('slug'))->delete();
        return redirect()->route('Datauji.index')->with('message', 'Data Datauji Berhasil Di Hapus!!');
    }
}
