<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateViewOutpatients extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE VIEW view_outpatients AS
            SELECT 
                p.\"patientID\",
                p.\"fname\",
                p.\"lname\",
                p.\"address\",
                p.\"phone\",
                p.\"dateofbirth\",
                p.\"sex\",
                p.\"dateregistered\",
                d.\"name\" AS doctor_name,
                a.\"appointmentDate\" AS latest_appointment_date,
                a.\"appointmentTime\" AS latest_appointment_time
            FROM patients p
            LEFT JOIN local_doctors d ON p.\"clinicID\" = d.\"clinicID\"
            LEFT JOIN (
                SELECT DISTINCT ON (\"patientID\") *
                FROM patient_appointments
                ORDER BY \"patientID\", \"appointmentDate\" DESC
            ) a ON p.\"patientID\" = a.\"patientID\"
            WHERE p.\"patienttype\" = 'outpatient'
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS view_outpatients");
    }
};
