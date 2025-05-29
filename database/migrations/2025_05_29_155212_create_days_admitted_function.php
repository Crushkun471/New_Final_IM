<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDaysAdmittedFunction extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION days_admitted(inpatient_id INTEGER)
            RETURNS INTEGER AS $$
            DECLARE
                admit_date DATE;
                leave_date DATE;
            BEGIN
                SELECT \"dateAdmittedInWard\" INTO admit_date
                FROM inpatients
                WHERE \"inpatientID\" = inpatient_id;

                IF admit_date IS NULL THEN
                    RETURN 0;
                END IF;

                SELECT COALESCE(\"actualLeave\", CURRENT_DATE) INTO leave_date
                FROM inpatients
                WHERE \"inpatientID\" = inpatient_id;

                RETURN leave_date - admit_date;
            END;
            $$ LANGUAGE plpgsql;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS days_admitted(INTEGER)");
    }
};
