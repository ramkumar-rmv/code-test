<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preparerRole = Role::firstOrCreate(['name' => 'preparer']);
        $approverRole = Role::firstOrCreate(['name' => 'approver']);

        // Create Preparer User
        $preparer = User::create([
            'name' => 'Preparer User',
            'email' => 'preparer@example.com',
            'password' => Hash::make('password'),
        ]);

        $preparer->roles()->attach($preparerRole);

        // Create Approver User
        $approver = User::create([
            'name' => 'Approver User',
            'email' => 'approver@example.com',
            'password' => Hash::make('password'),
        ]);

        $approver->roles()->attach($approverRole);
    }
}
