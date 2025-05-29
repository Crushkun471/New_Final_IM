<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Manage Staff Information</h2>
    </x-slot>

    <div style="padding: 20px;">

        {{-- Accordion Header --}}
        <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Staff List</div>

        {{-- Search and Sort --}}
        <div style="border: 1px solid #ccc; padding: 10px; border-top: none; display: flex; justify-content: space-between; align-items: center;">
            <form method="GET" action="{{ route('staff.index') }}" style="display: flex; gap: 10px; width: 100%;">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                       style="padding: 5px; width: 30%; border: 1px solid #ccc;">
                <button type="submit" style="padding: 5px 10px; background-color: #444; color: white; border: none;">Search</button>

                <select name="sort" onchange="this.form.submit()" style="margin-left: auto; padding: 5px; border: 1px solid #ccc;">
                    <option value="">Sort</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="position" {{ request('sort') == 'position' ? 'selected' : '' }}>Position</option>
                </select>
            </form>
        </div>

        {{-- Add Staff Button --}}
        <div style="margin: 10px 0;">
            <a href="{{ route('staff.create') }}" style="padding: 8px 12px; background-color: green; color: white; text-decoration: none; border-radius: 4px;">➕ Add Staff</a>
        </div>


        {{-- Table --}}
        <div style="overflow-x: auto; border: 1px solid #ccc; border-top: none;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead style="background-color: #444; color: white;">
                    <tr>
                        <th style="padding: 8px; border: 1px solid #ccc;">Staff #</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Staff Name</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Sex</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Address</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Phone Number</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Date of Birth</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Ward Number</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Insurance Number</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Salary Scale</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Position</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Current Salary</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staff as $s)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $s->staffID }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $s->name }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $s->sex }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $s->address }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $s->telephone }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $s->dateOfBirth }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $s->ward->wardName ?? '-' }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $s->nationalInsuranceNumber }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $s->salaryScale }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $s->position }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ number_format($s->currentSalary, 2) }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">
                                <a href="{{ route('staff.edit', $s->staffID) }}" style="color: blue; text-decoration: underline; margin-right: 10px;">Edit</a>
                                <form method="POST" action="{{ route('staff.destroy', $s->staffID) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this staff member?')" style="color: red; background: none; border: none; text-decoration: underline; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" style="text-align: center; padding: 12px; color: gray;">No staff found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 20px;">
            {{ $staff->links() }}
        </div>
    </div>
</x-app-layout>
