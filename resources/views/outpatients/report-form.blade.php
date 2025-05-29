<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Generate Outpatient Report</h2>
    </x-slot>

    <div style="padding: 20px;">
        {{-- Accordion Header --}}
        <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">
            Generate Out-Patients Clinic Report
            <small style="font-weight: normal; opacity: 0.9; margin-left: 10px;">For Charge Nurse and Medical Director</small>
        </div>

        {{-- Report Form --}}
        <div style="border: 1px solid #ccc; padding: 20px; border-top: none; background-color: white;">
            <form action="{{ route('outpatients.report.generate') }}" method="GET" target="_blank">
                <div style="display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 200px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #444;">From Date</label>
                        <input type="date"
                            name="date_from"
                            style="padding: 8px; width: 100%; border: 1px solid #ccc;"
                            max="{{ date('Y-m-d') }}">
                        <small style="color: #666; font-size: 12px;">Filter patients registered from this date</small>
                    </div>

                    <div style="flex: 1; min-width: 200px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #444;">To Date</label>
                        <input type="date"
                            name="date_to"
                            style="padding: 8px; width: 100%; border: 1px solid #ccc;"
                            max="{{ date('Y-m-d') }}">
                        <small style="color: #666; font-size: 12px;">Filter patients registered until this date</small>
                    </div>
                </div>

                <div style="display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="flex: 2; min-width: 300px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #444;">Search Filter (Optional)</label>
                        <input type="text"
                            name="search"
                            placeholder="Search by first name, last name, or phone number"
                            style="padding: 8px; width: 100%; border: 1px solid #ccc;">
                        <small style="color: #666; font-size: 12px;">Leave empty to include all outpatients</small>
                    </div>

                    <div style="flex: 1; min-width: 200px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #444;">Quick Date Ranges</label>
                        <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                            <button type="button"
                                style="padding: 5px 10px; background-color: #444; color: white; border: none; font-size: 12px;"
                                onclick="setDateRange('today')">Today</button>
                            <button type="button"
                                style="padding: 5px 10px; background-color: #444; color: white; border: none; font-size: 12px;"
                                onclick="setDateRange('week')">This Week</button>
                            <button type="button"
                                style="padding: 5px 10px; background-color: #444; color: white; border: none; font-size: 12px;"
                                onclick="setDateRange('month')">This Month</button>
                            <button type="button"
                                style="padding: 5px 10px; background-color: #444; color: white; border: none; font-size: 12px;"
                                onclick="setDateRange('year')">This Year</button>
                        </div>
                    </div>
                </div>

                <div style="background-color: #e6f3ff; border: 1px solid #b3d9ff; padding: 15px; margin-bottom: 15px;">
                    <strong style="color: #444;">Report Contents:</strong>
                    <ul style="margin: 10px 0 0 20px; color: #444;">
                        <li>Complete list of outpatient referrals</li>
                        <li>Patient demographics and contact information</li>
                        <li>Referral doctor details</li>
                        <li>Appointment history and scheduling</li>
                        <li>Summary statistics and analytics</li>
                    </ul>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                    <div>
                        <a href="{{ route('outpatients.index') }}"
                            style="padding: 8px 15px; background-color: #ccc; color: #444; text-decoration: none; border: 1px solid #999;">
                            ← Back to Outpatients
                        </a>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="button"
                            style="padding: 8px 15px; background-color: #f39c12; color: white; border: none;"
                            onclick="clearFilters()">Clear Filters</button>
                        <button type="submit"
                            style="padding: 8px 15px; background-color: #e3342f; color: white; border: none;">
                            Generate PDF Report
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Preview Section --}}
        <div style="margin-top: 20px;">
            <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Report Preview Information</div>
            <div style="border: 1px solid #ccc; padding: 20px; border-top: none; background-color: #f8f9fa;">
                <div style="display: flex; gap: 20px; justify-content: space-around; flex-wrap: wrap;">
                    <div style="text-align: center; padding: 15px; border: 1px solid #ccc; background-color: white; min-width: 150px;">
                        <div style="font-size: 18px; color: #e3342f; font-weight: bold;">👥</div>
                        <div style="font-weight: bold; margin: 5px 0;">Total Outpatients</div>
                        <div id="total-count" style="font-size: 24px; color: #e3342f; font-weight: bold;">Loading...</div>
                    </div>
                    <div style="text-align: center; padding: 15px; border: 1px solid #ccc; background-color: white; min-width: 150px;">
                        <div style="font-size: 18px; color: #28a745; font-weight: bold;">📅</div>
                        <div style="font-weight: bold; margin: 5px 0;">With Appointments</div>
                        <div id="appointment-count" style="font-size: 24px; color: #28a745; font-weight: bold;">Loading...</div>
                    </div>
                    <div style="text-align: center; padding: 15px; border: 1px solid #ccc; background-color: white; min-width: 150px;">
                        <div style="font-size: 18px; color: #f39c12; font-weight: bold;">👨‍⚕️</div>
                        <div style="font-weight: bold; margin: 5px 0;">With Referral Doctors</div>
                        <div id="referral-count" style="font-size: 24px; color: #f39c12; font-weight: bold;">Loading...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setDateRange(period) {
            const today = new Date();
            const dateFrom = document.querySelector('input[name="date_from"]');
            const dateTo = document.querySelector('input[name="date_to"]');

            // Set end date to today
            dateTo.value = today.toISOString().split('T')[0];

            let startDate = new Date();

            switch (period) {
                case 'today':
                    startDate = today;
                    break;
                case 'week':
                    startDate.setDate(today.getDate() - 7);
                    break;
                case 'month':
                    startDate.setMonth(today.getMonth() - 1);
                    break;
                case 'year':
                    startDate.setFullYear(today.getFullYear() - 1);
                    break;
            }

            dateFrom.value = startDate.toISOString().split('T')[0];
        }

        function clearFilters() {
            document.querySelector('input[name="date_from"]').value = '';
            document.querySelector('input[name="date_to"]').value = '';
            document.querySelector('input[name="search"]').value = '';
        }

        // Load preview statistics
        document.addEventListener('DOMContentLoaded', function() {
            // You would implement an AJAX call here to get actual counts
            // For now, showing placeholder functionality

            fetch('{{ route("outpatients.stats") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-count').textContent = data.total || '0';
                    document.getElementById('appointment-count').textContent = data.with_appointments || '0';
                    document.getElementById('referral-count').textContent = data.with_referrals || '0';
                })
                .catch(error => {
                    console.log('Stats loading failed:', error);
                    document.getElementById('total-count').textContent = '0';
                    document.getElementById('appointment-count').textContent = '0';
                    document.getElementById('referral-count').textContent = '0';
                });
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const dateFrom = document.querySelector('input[name="date_from"]').value;
            const dateTo = document.querySelector('input[name="date_to"]').value;

            if (dateFrom && dateTo && new Date(dateFrom) > new Date(dateTo)) {
                e.preventDefault();
                alert('From date cannot be later than To date.');
                return false;
            }
        });
    </script>
</x-app-layout>