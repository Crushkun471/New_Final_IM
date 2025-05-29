<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceOnWaitlistProcedure extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE OR REPLACE PROCEDURE place_patient_on_waitlist(
                IN p_patient_id INTEGER
            )
            LANGUAGE plpgsql
            AS $$
            BEGIN
                INSERT INTO inpatients (
                    \"patientID\",
                    \"datePlacedOnWaitlist\",
                    \"wardRequired\",
                    \"expectedDaysToStay\",
                    \"wardID\",
                    \"bedID\",
                    \"dateAdmittedInWard\",
                    \"expectedLeave\",
                    \"actualLeave\",
                    created_at,
                    updated_at
                ) VALUES (
                    p_patient_id,
                    CURRENT_DATE,
                    'Waiting List',
                    0,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    NULL,
                    CURRENT_TIMESTAMP,
                    CURRENT_TIMESTAMP
                );
            END;
            $$;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS place_patient_on_waitlist(INTEGER)");
    }
};
