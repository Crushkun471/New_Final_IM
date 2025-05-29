<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateViewInpatients extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            DROP VIEW IF EXISTS view_inpatients;

            CREATE VIEW view_inpatients AS
            SELECT
                i.\"inpatientID\",
                i.\"patientID\",
                p.\"fname\",
                p.\"lname\",
                p.\"sex\",
                p.\"address\",
                i.\"wardID\",
                w.\"wardName\",
                i.\"bedID\",
                b.\"bedNumber\",
                i.\"datePlacedOnWaitlist\",
                i.\"wardRequired\",
                i.\"expectedDaysToStay\",
                i.\"dateAdmittedInWard\",
                i.\"expectedLeave\",
                i.\"actualLeave\",
                CASE
                    WHEN i.\"actualLeave\" IS NOT NULL THEN 'discharged'
                    WHEN i.\"dateAdmittedInWard\" IS NOT NULL THEN 'admitted'
                    ELSE 'waiting'
                END AS status
            FROM inpatients i
            LEFT JOIN patients p ON p.\"patientID\" = i.\"patientID\"
            LEFT JOIN wards w ON w.\"wardID\" = i.\"wardID\"
            LEFT JOIN beds b ON b.\"bedID\" = i.\"bedID\"
        ");

    }

    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS view_inpatients");
    }
};
