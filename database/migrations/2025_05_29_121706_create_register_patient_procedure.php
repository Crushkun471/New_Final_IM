<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterPatientProcedure extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE OR REPLACE PROCEDURE register_patient(
                IN p_fname TEXT,
                IN p_lname TEXT,
                IN p_patienttype TEXT,
                IN p_address TEXT,
                IN p_phone TEXT,
                IN p_dateofbirth DATE,
                IN p_sex TEXT,
                IN p_maritalstatus TEXT,
                IN p_dateregistered DATE,
                IN p_clinicID INTEGER,

                IN p_kin_name TEXT,
                IN p_kin_relationship TEXT,
                IN p_kin_address TEXT,
                IN p_kin_phone TEXT,

                IN p_appointment_date DATE,
                IN p_appointment_time TIME,
                IN p_exam_room TEXT,
                IN p_staffID INTEGER
            )
            LANGUAGE plpgsql
            AS $$
            DECLARE
                new_patient_id INTEGER;
            BEGIN
                INSERT INTO patients (
                    \"fname\", \"lname\", \"patienttype\", \"address\", \"phone\",
                    \"dateofbirth\", \"sex\", \"maritalstatus\", \"dateregistered\", \"clinicID\",
                    created_at, updated_at
                ) VALUES (
                    p_fname, p_lname, p_patienttype, p_address, p_phone,
                    p_dateofbirth, p_sex, p_maritalstatus, p_dateregistered, p_clinicID,
                    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
                )
                RETURNING \"patientID\" INTO new_patient_id;

                INSERT INTO next_of_kin (
                    \"patientID\", \"name\", \"relationship\", \"address\", \"phone\",
                    created_at, updated_at
                ) VALUES (
                    new_patient_id, p_kin_name, p_kin_relationship, p_kin_address, p_kin_phone,
                    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
                );

                INSERT INTO patient_appointments (
                    \"patientID\", \"staffID\", \"appointmentDate\", \"appointmentTime\",
                    \"examinationRoom\", created_at, updated_at
                ) VALUES (
                    new_patient_id, p_staffID, p_appointment_date, p_appointment_time,
                    p_exam_room, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
                );
            END;
            $$;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS register_patient(...long list...)");
    }
};