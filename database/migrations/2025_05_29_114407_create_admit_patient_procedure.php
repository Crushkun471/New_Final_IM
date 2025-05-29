<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateAdmitPatientProcedure extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE OR REPLACE PROCEDURE admit_patient_procedure(
                IN p_inpatient_id INTEGER,
                IN p_ward_id INTEGER,
                IN p_bed_id INTEGER,
                IN p_date_admitted DATE,
                IN p_expected_days INTEGER
            )
            LANGUAGE plpgsql
            AS $$
            DECLARE
                v_expected_leave DATE;
            BEGIN
                v_expected_leave := p_date_admitted + p_expected_days;

                UPDATE inpatients
                SET
                    \"wardID\" = p_ward_id,
                    \"bedID\" = p_bed_id,
                    \"dateAdmittedInWard\" = p_date_admitted,
                    \"expectedDaysToStay\" = p_expected_days,
                    \"expectedLeave\" = v_expected_leave,
                    \"actualLeave\" = NULL
                WHERE \"inpatientID\" = p_inpatient_id;
            END;
            $$;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS admit_patient_procedure(INTEGER, INTEGER, INTEGER, DATE, INTEGER)");
    }
};
