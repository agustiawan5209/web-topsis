<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Admin']);
        $orangtua = Role::create(['name' => 'Pengguna']);



        $user = User::factory()->create([
            'name' => 'Admin',
            'username' => 'Admin',
            'email' => 'Admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole($role);


    }
}
