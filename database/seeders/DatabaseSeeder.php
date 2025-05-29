<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Truncate child tables first to avoid FK conflicts
        DB::table('beds')->truncate();
        DB::table('wards')->truncate();

        Schema::enableForeignKeyConstraints();

        // Now seed wards first, then beds
        $this->call(WardSeeder::class);
        $this->call(BedSeeder::class);
    }
}

