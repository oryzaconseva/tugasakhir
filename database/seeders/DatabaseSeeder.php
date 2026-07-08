<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'administrator@msi.ac.id'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'role' => 'administrator',
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'admin@msi.ac.id'],
            [
                'name' => 'HR',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
    }
}
