<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Patient Information</h2>
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

        <form method="POST" action="{{ route('patients.update', $patient->patientID) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Patient Info --}}
            <button type="button" onclick="toggleSection('patientInfo')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">
                Patient Information
            </button>

            <div id="patientInfo" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <label for="fname" class="block font-medium">First Name</label>
                        <input id="fname" name="fname" type="text" value="{{ old('fname', $patient->fname) }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="lname" class="block font-medium">Last Name</label>
                        <input id="lname" name="lname" type="text" value="{{ old('lname', $patient->lname) }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div class="col-span-2">
                        <label for="address" class="block font-medium">Address</label>
                        <input id="address" name="address" type="text" value="{{ old('address', $patient->address) }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="phone" class="block font-medium">Phone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $patient->phone) }}" class="w-full border rounded px-2 py-1" >
                    </div>
                    <div>
                        <label for="dateofbirth" class="block font-medium">Date of Birth</label>
                        <input id="dateofbirth" name="dateofbirth" type="date" value="{{ old('dateofbirth', $patient->dateofbirth ? \Carbon\Carbon::parse($patient->dateofbirth)->format('Y-m-d') : '') }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="sex" class="block font-medium">Sex</label>
                        <select id="sex" name="sex" class="w-full border rounded px-2 py-1" required>
                            <option value="">Select</option>
                            <option value="M" {{ old('sex', $patient->sex) == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ old('sex', $patient->sex) == 'F' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="maritalstatus" class="block font-medium">Marital Status</label>
                        <select id="maritalstatus" name="maritalstatus" class="w-full border rounded px-2 py-1" required>
                            <option value="">Select</option>
                            <option value="single" {{ old('maritalstatus', $patient->maritalstatus) == 'single' ? 'selected' : '' }}>Single</option>
                            <option value="married" {{ old('maritalstatus', $patient->maritalstatus) == 'married' ? 'selected' : '' }}>Married</option>
                            <option value="divorced" {{ old('maritalstatus', $patient->maritalstatus) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="widowed" {{ old('maritalstatus', $patient->maritalstatus) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                        </select>
                    </div>
                    <div>
                        <label for="dateregistered" class="block font-medium">Date Registered</label>
                        <input id="dateregistered" name="dateregistered" type="date" value="{{ old('dateregistered', $patient->dateregistered ? \Carbon\Carbon::parse($patient->dateregistered)->format('Y-m-d') : '') }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="patienttype" class="block font-medium">Patient Type</label>
                        <select id="patienttype" name="patienttype" class="w-full border rounded px-2 py-1" required>
                            <option value="">Select</option>
                            <option value="inpatient" {{ old('patienttype', $patient->patienttype) == 'inpatient' ? 'selected' : '' }}>Inpatient</option>
                            <option value="outpatient" {{ old('patienttype', $patient->patienttype) == 'outpatient' ? 'selected' : '' }}>Outpatient</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Next of Kin --}}
            <button type="button" onclick="toggleSection('nextOfKin')" class="w-full bg-red-600 text-white font-semibold py-2 px-4 mt-4">
                Next of Kin Information
            </button>
            <div id="nextOfKin" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <label for="nok_fname" class="block font-medium">First Name</label>
                        <input id="nok_fname" name="nok_fname" type="text" value="{{ old('nok_fname', $patient->nok_fname) }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="nok_lname" class="block font-medium">Last Name</label>
                        <input id="nok_lname" name="nok_lname" type="text" value="{{ old('nok_lname', $patient->nok_lname) }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div class="col-span-2">
                        <label for="nok_address" class="block font-medium">Address</label>
                        <input id="nok_address" name="nok_address" type="text" value="{{ old('nok_address', $patient->nok_address) }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="nok_phone" class="block font-medium">Phone</label>
                        <input id="nok_phone" name="nok_phone" type="text" value="{{ old('nok_phone', $patient->nok_phone) }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="nok_relationship" class="block font-medium">Relationship</label>
                        <input id="nok_relationship" name="nok_relationship" type="text" value="{{ old('nok_relationship', $patient->nok_relationship) }}" class="w-full border rounded px-2 py-1" required>
                    </div>
                </div>
            </div>

            {{-- Local Doctor --}}
            <button type="button" onclick="toggleSection('localDoctor')" class="w-full bg-red-600 text-white font-semibold py-2 px-4 mt-4">
                Local Doctor Information
            </button>
            <div id="localDoctor" class="border p-4 space-y-3">
                <label for="clinicID" class="block font-medium">Select Clinic</label>
                <select id="clinicID" name="clinicID" class="w-full border rounded px-2 py-1">
                    <option value="">-- Select Clinic --</option>
                    @foreach ($localDoctors as $doc)
                        <option value="{{ $doc->clinicID }}" {{ old('clinicID', $patient->clinicID) == $doc->clinicID ? 'selected' : '' }}>
                            {{ $doc->clinicName }} ({{ $doc->address }})
                        </option>
                    @endforeach
                </select>
            </div>  

            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 mt-6">
                Save Changes
            </button>
        </form>
    </div>

    <script>
        function toggleSection(id) {
            let el = document.getElementById(id);
            if(el.style.display === 'none' || el.style.display === '') {
                el.style.display = 'block';
            } else {
                el.style.display = 'none';
            }
        }

        // Initially show sections
        document.getElementById('patientInfo').style.display = 'block';
        document.getElementById('nextOfKin').style.display = 'block';
        document.getElementById('localDoctor').style.display = 'block';
    </script>
</x-app-layout>
