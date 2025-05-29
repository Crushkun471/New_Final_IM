<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add a Staff</h2>
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

        <form method="POST" action="{{ route('staff.store') }}" class="space-y-6">
            @csrf

            {{-- Staff Information --}}
            <button type="button" onclick="toggleSection('staffInfo')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">Staff Information</button>
            <div id="staffInfo" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><label>First Name</label><input name="fname" class="w-full border" required></div>
                    <div><label>Last Name</label><input name="lname" class="w-full border" required></div>
                    <div class="col-span-2"><label>Address</label><input name="address" class="w-full border" required></div>
                    <div><label>Gender</label>
                        <select name="sex" class="w-full border" required>
                            <option value="">Select</option><option value="M">Male</option><option value="F">Female</option>
                        </select>
                    </div>
                    <div><label>Date of Birth</label><input type="date" name="dateOfBirth" class="w-full border" required></div>
                    <div><label>Phone</label><input name="telephone" class="w-full border"></div>
                    <div><label>Ward</label>
                        <select name="wardID" class="w-full border">
                            <option value="">-- None --</option>
                            @foreach ($wards as $ward)
                                <option value="{{ $ward->wardID }}">{{ $ward->wardName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Staff Contract --}}
            <button type="button" onclick="toggleSection('staffContract')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">Staff Contract</button>
            <div id="staffContract" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><label>Insurance Number</label><input name="nationalInsuranceNumber" class="w-full border" required></div>
                    <div><label>Salary Scale</label>
                        <select name="salaryScale" class="w-full border" required>
                            <option value="">Select</option>
                            <option value="15,000 - 20,000">15,000 - 20,000</option>
                            <option value="20,000 - 30,000">20,000 - 30,000</option>
                            <option value="30,000 - 40,000">30,000 - 40,000</option>
                            <option value="40,000 - above">40,000 - above</option>
                        </select>
                    </div>
                    <div><label>Position</label>
                        <select name="position" class="w-full border" required>
                            <option value="">Select</option>
                            <option value="Medical Doctor">Medical Doctor</option>
                            <option value="Medical Director">Medical Director</option>
                            <option value="Personnel Officer">Personnel Officer</option>
                            <option value="Charge Nurse">Charge Nurse</option>
                            <option value="Specialist Staff">Specialist Staff</option>
                        </select>
                    </div>
                    <div><label>Current Salary</label><input type="number" step="0.01" name="currentSalary" class="w-full border" required></div>
                    <div><label>Contract Type</label>
                        <select name="contractType" class="w-full border" required>
                            <option value="">Select</option>
                            <option value="temporary">Temporary</option>
                            <option value="permanent">Permanent</option>
                        </select>
                    </div>
                    <div><label>Payment Type</label>
                        <select name="paymentType" class="w-full border" required>
                            <option value="">Select</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div><label>Hours Per Week</label>
                        <input type="number" name="hoursPerWeek" class="w-full border" required>
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex justify-center space-x-6 pt-4">
                <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded">Add Staff</button>
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
