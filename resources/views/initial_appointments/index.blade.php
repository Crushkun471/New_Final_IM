<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #1f2937;">Initial Appointment</h2>
    </x-slot>

    <div class="p-6 space-y-6" style="font-size: 1.1rem; text-align: center;">

        {{-- Upcoming Appointments --}}
        <button type="button" onclick="toggleSection('upcomingSection')" 
                style="width: 100%; background-color: #dc2626; color: white; font-weight: bold; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer;">
            Upcoming Appointments
        </button>
        <div id="upcomingSection" style="border: 1px solid #fca5a5; padding: 16px; border-radius: 6px; margin-top: 10px;">
            <select id="patientSelect" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #d1d5db;">
                <option value="">Select Patient</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->patientID }}">
                        {{ $patient->fname }} {{ $patient->lname }} ({{ $patient->patienttype }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Appointment Info --}}
        <button type="button" onclick="toggleSection('infoSection')" 
                style="width: 100%; background-color: #dc2626; color: white; font-weight: bold; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; margin-top: 20px;">
            Appointment Information
        </button>
        <div id="infoSection" style="border: 1px solid #fca5a5; padding: 16px; border-radius: 6px; margin-top: 10px; background-color: #fef2f2;">
            <div id="appointmentDetails" style="text-align: left;">
                <p>Select a patient to view appointments.</p>
            </div>
        </div>

        {{-- Conduct Appointment --}}
        <button type="button" onclick="toggleSection('conductSection')" 
                style="width: 100%; background-color: #dc2626; color: white; font-weight: bold; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; margin-top: 20px;">
            Conduct Appointment
        </button>
        <form method="POST" action="{{ route('initial-appointments.submit') }}" style="border: 1px solid #fca5a5; padding: 16px; border-radius: 6px; margin-top: 10px;" id="conductSection">
            @csrf
            <input type="hidden" name="patient_id" id="selectedPatientID">
            <div id="patientTypeInfo" style="font-weight: 500; color: #1f2937;">
                Select a patient to determine type.
            </div>
            <button type="submit" 
                    style="background-color: #2563eb; color: white; padding: 10px 20px; border: none; border-radius: 6px; margin-top: 10px; cursor: pointer;"
                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                    onmouseout="this.style.backgroundColor='#2563eb'">
                Submit Examination
            </button>
        </form>

    </div>

    <script>
        function toggleSection(id) {
            const section = document.getElementById(id);
            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }

        // Show all sections by default
        ['upcomingSection', 'infoSection', 'conductSection'].forEach(id => {
            document.getElementById(id).style.display = 'block';
        });

        document.getElementById('patientSelect').addEventListener('change', function () {
            const patientID = this.value;
            const typeDisplay = document.getElementById('patientTypeInfo');
            const selectedText = this.options[this.selectedIndex].text;

            document.getElementById('selectedPatientID').value = patientID;

            if (selectedText.includes('outpatient')) {
                typeDisplay.textContent = "Patient Type: Outpatient (will be redirected to Outpatients)";
            } else if (selectedText.includes('inpatient')) {
                typeDisplay.textContent = "Patient Type: Inpatient (will be redirected to Waitlist)";
            } else {
                typeDisplay.textContent = "Patient Type: Unknown";
            }

        fetch(`/initial-appointments/appointment-info/${patientID}`)
            .then(res => res.json())
            .then(data => {
                const infoDiv = document.getElementById('appointmentDetails');
                if (data.length === 0) {
                    infoDiv.innerHTML = "<p>No appointment records found.</p>";
                    return;
                }

                let html = "<div style='text-align: left;'>";
                data.forEach(appt => {
                    html += `<div style="border: 1px solid #d1d5db; padding: 12px; margin-bottom: 10px; background-color: #f9fafb; border-radius: 5px;">
                        <div><strong>Appointment #:</strong> ${appt.appointmentID}</div>
                        <div><strong>Staff:</strong> ${appt.staff?.name ?? 'N/A'}</div>
                        <div><strong>Room:</strong> ${appt.examinationRoom}</div>
                        <div><strong>Date:</strong> ${appt.appointmentDate}</div>
                        <div><strong>Time:</strong> ${appt.appointmentTime}</div>
                        <div><strong>Outcome:</strong> ${appt.appointmentOutcome ?? 'N/A'}</div>
                    </div>`;
                });
                html += "</div>";
                infoDiv.innerHTML = html;
            });

        });
    </script>
</x-app-layout>
