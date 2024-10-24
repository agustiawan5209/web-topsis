<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Balita;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
        if(Auth::check()){
            abort(401, 'Maaf Akses anda Ditolak');
        }
        // dd(Auth::user());

    }

    public function validate(Request $request, array $rules, array $messages = [], array $attributes = [])
    {
        $role = Auth::user()->getRoleNames()->toArray();

        if(in_array('Admin', $role)){
            return redirect()->route('dashboard');
        }

        if(in_array('Pengguna', $role)){
            return redirect()->route('dashboard.pengguna');
        }else{
            Auth::logout();
        }
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard',[
            'pengguna'=> User::role('Pengguna')->count(),
            'kriteria'=> Kriteria::all()->count(),
        ]);
    }

    public function dashboardPengguna()
    {
        // Auth::logout();
        // dd(Auth::user()->orangtua);
        return Inertia::render('User/Dashboard',[
            'pengguna'=> User::role('Pengguna')->count(),
        ]);
    }

    public function petunjuk(){
        return Inertia::render('Petunjuk/Index');
    }
}
