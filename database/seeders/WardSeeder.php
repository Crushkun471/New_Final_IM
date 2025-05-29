<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardSeeder extends Seeder
{
    public function run()
    {
        // Insert wards after truncation is handled in DatabaseSeeder
        $wards = [];
        for ($i = 1; $i <= 17; $i++) {
            $wards[] = [
                'wardID' => $i,
                'wardName' => 'Ward ' . $i,
                'location' => 'Location ' . $i,
                'totalBeds' => 14,  // change this if you want different number per ward
                'telExtension' => '100' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('wards')->insert($wards);
    }
}
