<?php

namespace Database\Seeders;

use App\Models\Balita;
use App\Models\OrangTua;
use App\Models\PegawaiPosyandu;
use App\Models\RiwayatImunisasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $org = User::factory(30)
            ->afterCreating(function (User $user) {
                $role = Role::findByName('Pengguna'); // Replace 'user' with your actual role name
                if ($role) {
                    $user->assignRole($role); // Assign 'user' role to the user
                }
                $user->givePermissionTo([
                    'show riwayat',
                    'add balita',
                    'edit balita',
                    'delete balita',
                    'show balita',
                    'show jadwal',
                    'show sertifikat',
                    'cetak sertifikat',

                ]);
            })
            ->create();
    }
}
