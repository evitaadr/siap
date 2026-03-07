<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'superadmin',
            'admin',
            'karyawan',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['nama' => $roleName]);
        }

        User::firstOrCreate(
            ['username' => 'evitadwi'],
            [
                'nama_lengkap' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            ['username' => 'evitadwir'],
            [
                'nama_lengkap' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            ['username' => 'evitadwiretnowati'],
            [
                'nama_lengkap' => 'Karyawan User',
                'password' => Hash::make('password'),
            ]
        );

        $superadmin = User::where('username', 'evitadwi')->first();
        $admin = User::where('username', 'evitadwir')->first();
        $karyawan = User::where('username', 'evitadwiretnowati')->first();

        if ($superadmin) {
            $superadmin->assignRole(['superadmin']);
        }

        if ($admin) {
            $admin->assignRole(['admin']);
        }

        if ($karyawan) {
            $karyawan->assignRole(['karyawan']);
        }
    }
}
