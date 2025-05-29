<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BedController; // Add this line if not already there
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffExperienceController;
use App\Http\Controllers\StaffQualificationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\InitialAppointmentController;
use App\Http\Controllers\OutpatientController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LocalDoctorController;
use App\Http\Controllers\InpatientController;
use App\Http\Controllers\SupplyController; // <-- Use combined controller
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WardRequisitionController;
use App\Http\Controllers\MedicationController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === STAFF ===
    Route::resource('staff', StaffController::class);

    // === STAFF EXPERIENCE ===
    Route::get('/experience', [StaffExperienceController::class, 'index'])->name('experience.index');
    Route::get('/experience/create', [StaffExperienceController::class, 'create'])->name('experience.create');
    Route::post('/experience/store', [StaffExperienceController::class, 'store'])->name('experience.store');
    Route::get('/experience/{experience}/edit', [StaffExperienceController::class, 'edit'])->name('experience.edit');
    Route::put('/experience/{experience}', [StaffExperienceController::class, 'update'])->name('experience.update');
    Route::delete('/experience/{experience}', [StaffExperienceController::class, 'destroy'])->name('experience.destroy');

    // === STAFF QUALIFICATIONS ===
    Route::get('/qualification', [StaffQualificationController::class, 'index'])->name('qualification.index');
    Route::get('/qualification/create', [StaffQualificationController::class, 'create'])->name('qualification.create');
    Route::post('/qualification/store', [StaffQualificationController::class, 'store'])->name('qualification.store');
    Route::get('/qualification/{qualification}/edit', [StaffQualificationController::class, 'edit'])->name('qualification.edit');
    Route::put('/qualification/{qualification}', [StaffQualificationController::class, 'update'])->name('qualification.update');
    Route::delete('/qualification/{qualification}', [StaffQualificationController::class, 'destroy'])->name('qualification.destroy');

    // === PATIENTS ===
    Route::resource('patients', PatientController::class);

    // === INITIAL APPOINTMENTS ===
    Route::get('/initial-appointments', [InitialAppointmentController::class, 'index'])->name('initial-appointments.index');
    Route::post('/initial-appointments/submit', [InitialAppointmentController::class, 'submit'])->name('initial-appointments.submit');
    Route::get('/initial-appointments/appointment-info/{patientID}', [InitialAppointmentController::class, 'getAppointmentInfo']);

    // Inpatient Routes
    Route::resource('inpatients', InpatientController::class);

    // Custom routes for Inpatient Management
    Route::get('inpatients/{inpatient}/admit-form', [InpatientController::class, 'admitPatientForm'])->name('inpatients.admitPatientForm');
    Route::put('inpatients/{inpatient}/admit', [InpatientController::class, 'admitPatient'])->name('inpatients.admit');
    Route::get('inpatients/{inpatient}/edit-admitted', [InpatientController::class, 'editAdmitted'])->name('inpatients.editAdmitted');
    Route::put('inpatients/{inpatient}/update-admitted', [InpatientController::class, 'updateAdmitted'])->name('inpatients.updateAdmitted');

    // === WARDS ===
    Route::resource('wards', WardController::class);

    // === BEDS ===
    Route::get('/get-beds-by-ward/{wardId}', [BedController::class, 'getBedsByWard']);

    // === WAITING LIST ===
    Route::get('/wards/waiting-list', [WaitingListController::class, 'index'])->name('wards.waiting-list');

    // === OUTPATIENTS ===
    Route::get('/outpatients', [OutpatientController::class, 'index'])->name('outpatients.index');
    Route::get('/outpatients', [OutpatientController::class, 'index'])->name('outpatients.index');
    Route::get('/outpatients/report', [OutpatientController::class, 'reportForm'])->name('outpatients.report.form');
    Route::get('/outpatients/report/generate', [OutpatientController::class, 'generateReport'])->name('outpatients.report.generate');
    Route::get('/outpatients/stats', [OutpatientController::class, 'getStats'])->name('outpatients.stats');

    // === LOCAL DOCTORS ===
    Route::prefix('doctors')->name('doctors.')->group(function () {
        Route::get('/', [LocalDoctorController::class, 'index'])->name('index');
        Route::get('/create', [LocalDoctorController::class, 'create'])->name('create');
        Route::post('/', [LocalDoctorController::class, 'store'])->name('store');
        Route::get('/{doctor}/edit', [LocalDoctorController::class, 'edit'])->name('edit');
        Route::put('/{doctor}', [LocalDoctorController::class, 'update'])->name('update');
        Route::delete('/{doctor}', [LocalDoctorController::class, 'destroy'])->name('destroy');
    });


    Route::resource('suppliers', SupplierController::class);

    // Pharma Supplies
    Route::resource('pharma-supplies', \App\Http\Controllers\PharmaSupplyController::class);

    // Surgical/Non-Surgical Supplies
    Route::resource('surg-supplies', \App\Http\Controllers\SurgNonSurgSupplyController::class);


    Route::get('/supplies/create', function () {
        return view('supplies.create');
    })->name('supplies.create');

    Route::get('/supplies', [\App\Http\Controllers\SupplyController::class, 'index'])->name('supplies.index');

    // === WARD REQUISITIONS ===
    Route::resource('requisitions', WardRequisitionController::class)->except(['edit', 'update', 'destroy']);
    Route::post('requisitions/{id}/accept', [WardRequisitionController::class, 'accept'])->name('requisitions.accept');

    // to prevent conflicts with the {medication} parameter.
    Route::get('medications/administer', [MedicationController::class, 'administer'])->name('medications.administer');
    Route::post('medications/administer', [MedicationController::class, 'storeAdministration'])->name('medications.administer.store');

    // Now define the resource routes. The 'show' route will be correctly matched after 'administer'.
    Route::resource('medications', MedicationController::class)->except(['edit', 'update', 'destroy']);


    // === REPORTS ===
    Route::get('/reports/staff-by-ward', [ReportController::class, 'staffByWard'])->name('reports.staffByWard');
    Route::get('/reports/staff-by-ward/pdf', [ReportController::class, 'staffByWardPdf'])->name('reports.staffByWard.pdf');

    // Patients in a Ward Report
    Route::get('/reports/patients-in-ward', [\App\Http\Controllers\ReportController::class, 'patientsInWard'])->name('reports.patientsInWard');
    Route::get('/reports/patients-in-ward/pdf', [\App\Http\Controllers\ReportController::class, 'patientsInWardPdf'])->name('reports.patientsInWard.pdf');

    Route::get('/reports/patient-medication', [\App\Http\Controllers\ReportController::class, 'patientMedication'])->name('reports.patientMedication');
    Route::get('/reports/patient-medication/pdf', [\App\Http\Controllers\ReportController::class, 'patientMedicationPdf'])->name('reports.patientMedication.pdf');

    Route::get('/reports/supplies-by-ward', [\App\Http\Controllers\ReportController::class, 'suppliesByWard'])->name('reports.suppliesByWard');
    Route::get('/reports/supplies-by-ward/pdf', [\App\Http\Controllers\ReportController::class, 'suppliesByWardPdf'])->name('reports.suppliesByWardPdf');
});


// Auth scaffolding
require __DIR__.'/auth.php';
