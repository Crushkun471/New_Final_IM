<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-dark-800 leading-tight">Register New Patient</h2>
    </x-slot>

    <div class="py-4 px-6">
        @if ($errors->any())
            <div class="text-red-600 mb-4 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('patients.store') }}" class="space-y-6">
            @csrf

            {{-- Patient Information --}}
            <button type="button" onclick="toggleSection('patientInfo')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">Patient Information</button>
            <div id="patientInfo" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><label>First Name</label><input name="fname" class="w-full border bg-white text-black" required></div>
                    <div><label>Last Name</label><input name="lname" class="w-full border bg-white text-black" required></div>
                    <div class="col-span-2"><label>Address</label><input name="address" class="w-full border bg-white text-black" required></div>
                    <div><label>Phone</label><input name="phone" class="w-full border bg-white text-black"></div>
                    <div><label>Date of Birth</label><input type="date" name="dateofbirth" class="w-full border bg-white text-black" required></div>
                    <div><label>Sex</label>
                        <select name="sex" class="w-full border bg-white text-black" required>
                            <option value="">Select</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                    <div>
                        <label>Marital Status</label>
                        <select name="maritalstatus" class="w-full border bg-white text-black" required>
                            <option value="">Select</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Prefer not to say">Prefer not to say</option>
                        </select>
                    </div>
                    <div><label>Patient Type</label>
                        <select name="patienttype" class="w-full border bg-white text-black" required>
                            <option value="">Select</option>
                            <option value="inpatient">Inpatient</option>
                            <option value="outpatient">Outpatient</option>
                        </select>
                    </div>
                    <div><label>Date Registered</label><input type="date" name="dateregistered" class="w-full border bg-white text-black" required></div>
                </div>
            </div>

            {{-- Next of Kin --}}
            <button type="button" onclick="toggleSection('nextOfKinInfo')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">Next of Kin Information</button>
            <div id="nextOfKinInfo" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><label>Name</label><input name="kin_name" class="w-full border bg-white text-black" required></div>
                    <div>
                        <label>Relationship</label>
                        <select name="kin_relationship" class="w-full border bg-white text-black" required>
                            <option value="">Select</option>
                            <option value="Spouse">Spouse</option>
                            <option value="Parent">Parent</option>
                            <option value="Sibling">Sibling</option>
                            <option value="Child">Child</option>
                            <option value="Guardian">Guardian</option>
                            <option value="Friend">Friend</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-span-2"><label>Address</label><input name="kin_address" class="w-full border bg-white text-black" required></div>
                    <div><label>Phone</label><input name="kin_phone" class="w-full border bg-white text-black" required></div>
                </div>
            </div>

            {{-- Local Doctor --}}
            <button type="button" onclick="toggleSection('doctorInfo')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">Local Doctor Referral</button>
            <div id="doctorInfo" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2">
                        <label>Doctor</label>
                        <select name="clinicID" class="w-full border bg-white text-black" required>
                            <option value="">-- Select Local Doctor --</option>
                            @foreach ($localDoctors as $doc)
                                <option value="{{ $doc->clinicID }}">{{ $doc->name }} | {{ $doc->phone }} | {{ $doc->address }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-sm text-blue-600 hover:underline cursor-pointer mt-2">
                    Want to add a new doctor? <a href="{{ route('doctors.create') }}" class="font-semibold underline">Click here</a>
                </div>
            </div>

            {{-- Appointment --}}
            <button type="button" onclick="toggleSection('appointmentInfo')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">Appointment</button>
            <div id="appointmentInfo" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><label>Date</label><input type="date" name="appointment_date" class="w-full border bg-white text-black" required></div>
                    <div><label>Time</label><input type="time" name="appointment_time" class="w-full border bg-white text-black" required></div>
                    <div><label>Examination Room</label><input name="examination_room" class="w-full border bg-white text-black" required></div>
                    <div><label>Outcome</label><input name="appointment_outcome" class="w-full border bg-white text-black"></div>
                    <div class="col-span-2">
                        <label>Staff</label>
                        <select name="staffID" class="w-full border bg-white text-black" required>
                            <option value="">-- Select Staff --</option>
                            @foreach ($staff as $s)
                                <option value="{{ $s->staffID }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex justify-center space-x-6 pt-4">
                <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded">Register Patient</button>
                <button type="reset" class="bg-white border border-gray-400 px-6 py-2 rounded">Clear</button>
            </div>
        </form>
    </div>

    <script>
        function toggleSection(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>
</x-app-layout>
