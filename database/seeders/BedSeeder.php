<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BedSeeder extends Seeder
{
    public function run()
    {
        // Insert beds after truncation and wards insertion is handled in DatabaseSeeder

        $bedID = 1;

        // Get wards from DB to seed beds per ward
        $wards = DB::table('wards')->get();

        foreach ($wards as $ward) {
            for ($i = 1; $i <= $ward->totalBeds; $i++) {
                DB::table('beds')->insert([
                    'bedID' => $bedID++,
                    'bedNumber' => $i,
                    'wardID' => $ward->wardID,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
