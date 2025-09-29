<?php

// database/seeders/FixUserPasswordSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FixUserPasswordSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->where('email', 'admin@sekolah.com')
          ->update(['password' => Hash::make('password')]);

        DB::table('users')->where('email', 'budi@sekolah.com')
          ->update(['password' => Hash::make('password')]);

        DB::table('users')->where('email', 'siti@sekolah.com')
          ->update(['password' => Hash::make('password')]);
    }
}
