<!-- resources/views/layouts/navigation.blade.php -->

<nav style="background-color: white; border-bottom: 1px solid #ddd; padding: 10px 40px; display: flex; align-items: center; justify-content: space-between;">
    <!-- Left: Logo and Nav Links -->
    <div style="display: flex; align-items: center;">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" style="margin-right: 30px; font-weight: bold; font-size: 18px; color: black; text-decoration: none;">
            <img style="width: 30px;" src="{{ asset('images/logo.jpg') }}">
        </a>

        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}" style="margin-right: 30px; color: black; text-decoration: none;">
            Dashboard
        </a>

        <!-- Staff Dropdown -->
        <div style="position: relative;">
            <button onclick="toggleDropdown()" style="background: none; border: none; font: inherit; color: black; cursor: pointer;">
                Staff ▼
            </button>

            <div id="staffDropdown" style="display: none; position: absolute; top: 30px; left: 0; background: white; border: 1px solid #ccc; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 10px; z-index: 1000;">
                <a href="{{ route('staff.create') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">➕ Add New Staff</a>
                <a href="{{ route('staff.index') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">🛠 Manage Staff Information</a>
                <a href="{{ route('experience.index') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">📜 Staff Work Experiences</a>
                <a href="{{ route('qualification.index') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">🎓 Staff Qualifications</a>
                <a href="{{ route('reports.staffByWard') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">📊 Reports by Ward</a>
            </div>
        </div>

        <!-- Patients Dropdown -->
        <div style="position: relative; margin-left: 20px;">
            <button onclick="togglePatientsDropdown()" style="background: none; border: none; font: inherit; color: black; cursor: pointer;">
                Patients ▼
            </button>

            <div id="patientsDropdown" style="display: none; position: absolute; top: 30px; left: 0; background: white; border: 1px solid #ccc; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 10px; z-index: 1000;">
                <a href="{{ route('patients.create') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">➕ Add New Patient</a>
                <a href="{{ route('patients.index') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">🛠 Manage Patient Information</a>
                <a href="{{ route('initial-appointments.index') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">📅 Initial Appointments</a>
                <a href="{{ route('outpatients.index')}}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">👨‍⚕️ View Outpatients</a>
                <a href="{{ route('reports.patientsInWard') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">🛏️ Patients in Ward</a>
            </div>
        </div>

        <!-- Wards Dropdown -->
        <div style="position: relative; margin-left: 20px;">
            <button onclick="toggleWardsDropdown()" style="background: none; border: none; font: inherit; color: black; cursor: pointer;">
                Wards ▼
            </button>

            <div id="wardsDropdown" style="display: none; position: absolute; top: 30px; left: 0; background: white; border: 1px solid #ccc; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 10px; z-index: 1000;">
                <a href="{{ route('wards.create')}}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">➕ Add New Ward</a>
                <a href="{{ route('wards.index')}}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">🛠 Manage Wards</a>
                <a href="{{ route('inpatients.index')}}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">⏳ Waiting List</a>
            </div>
        </div>

        <!-- Supplies Dropdown -->
        <div style="position: relative; margin-left: 20px;">
            <button onclick="toggleSuppliesDropdown()" style="background: none; border: none; font: inherit; color: black; cursor: pointer;">
                Supplies ▼
            </button>

            <div id="suppliesDropdown" style="display: none; position: absolute; top: 30px; left: 0; background: white; border: 1px solid #ccc; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 10px; z-index: 1000;">
                <a href="{{ route('supplies.create')}}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">➕ Add Supplies</a>
                <a href="{{ route('supplies.index')}}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">🗂 Manage Supplies</a>
                <a href="{{ route('requisitions.create') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">📝 Create a Requisition</a>
                <a href="{{ route('requisitions.index') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">📦 View Requisitions</a>
                <a href="{{ route('reports.suppliesByWard') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">📋 Supplies by Ward Report</a>
            </div>
        </div>


        <!-- Medication Dropdown -->
        <div style="position: relative; margin-left: 20px;">
            <button onclick="toggleMedicationDropdown()" style="background: none; border: none; font: inherit; color: black; cursor: pointer;">
                Medication ▼
            </button>

            <div id="medicationDropdown" style="display: none; position: absolute; top: 30px; left: 0; background: white; border: 1px solid #ccc; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 10px; z-index: 1000;">
                <a href="{{ route('medications.create') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">💊 Create Medication</a>
                <a href="{{ route('medications.administer') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">🩺 Administer Medication</a>
                <a href="{{ route('medications.index') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">📜 Medication History</a>
                <a href="{{ route('reports.patientMedication') }}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">📋 Medication Report by Patient</a>

            </div>
        </div>

        <!-- Others Dropdown -->
        <div style="position: relative; margin-left: 20px;">
            <button onclick="toggleOthersDropdown()" style="background: none; border: none; font: inherit; color: black; cursor: pointer;">
                Others ▼
            </button>

            <div id="othersDropdown" style="display: none; position: absolute; top: 30px; left: 0; background: white; border: 1px solid #ccc; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 10px; z-index: 1000;">
                <a href="{{ route('suppliers.create')}}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">➕ Add New Supplier</a>
                <a href="{{ route('suppliers.index')}}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">🛠 Manage Suppliers</a>
                <a href="{{ route('doctors.index')}}" style="display: block; padding: 5px 10px; color: black; text-decoration: none;">👨‍⚕️ Local Doctor Information</a>
            </div>
        </div>

    </div>

    <!-- Right: User Info -->
    <div>
        <span style="margin-right: 15px; color: black;">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" style="background: none; border: none; color: black; cursor: pointer;">Log Out</button>
        </form>
    </div>
</nav>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('staffDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('staffDropdown');
        const button = e.target.closest('button');
        if (!dropdown.contains(e.target) && (!button || button.innerText !== "Staff ▼")) {
            dropdown.style.display = 'none';
        }
    });
</script>

<script>
    function togglePatientsDropdown() {
        const dropdown = document.getElementById('patientsDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        const patientsDropdown = document.getElementById('patientsDropdown');
        const button = e.target.closest('button');
        if (!patientsDropdown.contains(e.target) && (!button || button.innerText !== "Patients ▼")) {
            patientsDropdown.style.display = 'none';
        }
    });
</script>

<script>
    function toggleWardsDropdown() {
        const dropdown = document.getElementById('wardsDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        const wardsDropdown = document.getElementById('wardsDropdown');
        const button = e.target.closest('button');
        if (!wardsDropdown.contains(e.target) && (!button || button.innerText !== "Wards ▼")) {
            wardsDropdown.style.display = 'none';
        }
    });
</script>

<script>
    function toggleOthersDropdown() {
        const dropdown = document.getElementById('othersDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        const othersDropdown = document.getElementById('othersDropdown');
        const button = e.target.closest('button');
        if (!othersDropdown.contains(e.target) && (!button || button.innerText !== "Others ▼")) {
            othersDropdown.style.display = 'none';
        }
    });
</script>

<script>
    function toggleSuppliesDropdown() {
        const dropdown = document.getElementById('suppliesDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        const suppliesDropdown = document.getElementById('suppliesDropdown');
        const button = e.target.closest('button');
        if (!suppliesDropdown.contains(e.target) && (!button || button.innerText !== "Supplies ▼")) {
            suppliesDropdown.style.display = 'none';
        }
    });
</script>


<script>
    function toggleMedicationDropdown() {
        const dropdown = document.getElementById('medicationDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        const medicationDropdown = document.getElementById('medicationDropdown');
        const button = e.target.closest('button');
        if (!medicationDropdown.contains(e.target) && (!button || button.innerText !== "Medication ▼")) {
            medicationDropdown.style.display = 'none';
        }
    });
</script>
