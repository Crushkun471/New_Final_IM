<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCalculateAgeFunction extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION calculate_age_in_years(birth_date DATE)
            RETURNS INTEGER AS $$
            BEGIN
                RETURN DATE_PART('year', AGE(CURRENT_DATE, birth_date));
            END;
            $$ LANGUAGE plpgsql IMMUTABLE;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS calculate_age_in_years(DATE)");
    }
};
