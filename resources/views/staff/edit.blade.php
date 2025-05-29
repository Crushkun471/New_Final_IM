<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Edit Staff Member</h2>
    </x-slot>

    <div style="padding: 20px;">

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('staff.update', $staff->staffID) }}">
            @csrf
            @method('PUT')

            <label>Full Name:</label><br>
            <input type="text" name="name" value="{{ old('name', $staff->name) }}" required style="width: 100%; margin-bottom: 10px;"><br>

            <label>Address:</label><br>
            <input type="text" name="address" value="{{ old('address', $staff->address) }}" required style="width: 100%; margin-bottom: 10px;"><br>

            <label>Phone Number:</label><br>
            <input type="text" name="telephone" value="{{ old('telephone', $staff->telephone) }}" required style="width: 100%; margin-bottom: 10px;"><br>

            <label>Date of Birth:</label><br>
            <input type="date" name="dateOfBirth" value="{{ old('dateOfBirth', $staff->dateOfBirth) }}" required style="width: 100%; margin-bottom: 10px;"><br>

            <label>Gender:</label><br>
            <select name="sex" required style="width: 100%; margin-bottom: 10px;">
                <option value="">-- Select --</option>
                <option value="M" {{ old('sex', $staff->sex) == 'M' ? 'selected' : '' }}>Male</option>
                <option value="F" {{ old('sex', $staff->sex) == 'F' ? 'selected' : '' }}>Female</option>
            </select><br>

            <label>Insurance Number:</label><br>
            <input type="text" name="nationalInsuranceNumber" value="{{ old('nationalInsuranceNumber', $staff->nationalInsuranceNumber) }}" required style="width: 100%; margin-bottom: 10px;"><br>

            <label>Position:</label><br>
            <select name="position" required style="width: 100%; margin-bottom: 10px;">
                <option value="">-- Select Position --</option>
                <option value="Medical Doctor" {{ old('position', $staff->position) == 'Medical Doctor' ? 'selected' : '' }}>Medical Doctor</option>
                <option value="Medical Director" {{ old('position', $staff->position) == 'Medical Director' ? 'selected' : '' }}>Medical Director</option>
                <option value="Personnel Officer" {{ old('position', $staff->position) == 'Personnel Officer' ? 'selected' : '' }}>Personnel Officer</option>
                <option value="Charge Nurse" {{ old('position', $staff->position) == 'Charge Nurse' ? 'selected' : '' }}>Charge Nurse</option>
                <option value="Specialist Staff" {{ old('position', $staff->position) == 'Specialist Staff' ? 'selected' : '' }}>Specialist Staff</option>
            </select><br>

            <label>Current Salary:</label><br>
            <input type="number" step="0.01" name="currentSalary" value="{{ old('currentSalary', $staff->currentSalary) }}" required style="width: 100%; margin-bottom: 10px;"><br>

            <label>Salary Scale:</label><br>
            <select name="salaryScale" required style="width: 100%; margin-bottom: 10px;">
                <option value="">-- Select Salary Scale --</option>
                <option value="15,000 - 20,000" {{ old('salaryScale', $staff->salaryScale) == '15,000 - 20,000' ? 'selected' : '' }}>15,000 - 20,000</option>
                <option value="20,000 - 30,000" {{ old('salaryScale', $staff->salaryScale) == '20,000 - 30,000' ? 'selected' : '' }}>20,000 - 30,000</option>
                <option value="30,000 - 40,000" {{ old('salaryScale', $staff->salaryScale) == '30,000 - 40,000' ? 'selected' : '' }}>30,000 - 40,000</option>
                <option value="40,000 - above" {{ old('salaryScale', $staff->salaryScale) == '40,000 - above' ? 'selected' : '' }}>40,000 - above</option>
            </select><br>

            <label>Contract Type:</label><br>
            <select name="contractType" required style="width: 100%; margin-bottom: 10px;">
                <option value="">-- Select --</option>
                <option value="temporary" {{ old('contractType', $staff->contractType) == 'temporary' ? 'selected' : '' }}>Temporary</option>
                <option value="permanent" {{ old('contractType', $staff->contractType) == 'permanent' ? 'selected' : '' }}>Permanent</option>
            </select><br>

            <label>Hours per Week:</label><br>
            <input type="number" name="hoursPerWeek" value="{{ old('hoursPerWeek', $staff->hoursPerWeek) }}" required style="width: 100%; margin-bottom: 10px;"><br>

            <label>Payment Type:</label><br>
            <select name="paymentType" required style="width: 100%; margin-bottom: 10px;">
                <option value="">-- Select --</option>
                <option value="weekly" {{ old('paymentType', $staff->paymentType) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ old('paymentType', $staff->paymentType) == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select><br>

            <label>Assign to Ward (optional):</label><br>
            <select name="wardID" style="width: 100%; margin-bottom: 20px;">
                <option value="">-- None --</option>
                @foreach ($wards as $ward)
                    <option value="{{ $ward->wardID }}" {{ old('wardID', $staff->wardID) == $ward->wardID ? 'selected' : '' }}>
                        {{ $ward->wardName }}
                    </option>
                @endforeach
            </select><br>

            <button type="submit" style="padding: 10px 20px; background-color: green; color: white; border: none;">Update</button>
        </form>
    </div>
</x-app-layout>
