<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Manage Staff Qualifications</h2>
    </x-slot>

    <div style="padding: 20px;">

        {{-- Accordion Header --}}
        <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Staff Qualifications List</div>

        {{-- Search and Sort --}}
        <div style="border: 1px solid #ccc; padding: 10px; border-top: none; display: flex; justify-content: space-between; align-items: center;">
            <form method="GET" action="{{ route('qualification.index') }}" style="display: flex; gap: 10px; width: 100%;">
                <input type="text" name="search" placeholder="Search by name, qualification, institution" value="{{ request('search') }}"
                       style="padding: 5px; width: 40%; border: 1px solid #ccc;">
                <button type="submit" style="padding: 5px 10px; background-color: #444; color: white; border: none;">Search</button>

                <select name="sort" onchange="this.form.submit()" style="margin-left: auto; padding: 5px; border: 1px solid #ccc;">
                    <option value="">Sort</option>
                    <option value="qualificationType" {{ request('sort') == 'qualificationType' ? 'selected' : '' }}>Qualification</option>
                    <option value="institution" {{ request('sort') == 'institution' ? 'selected' : '' }}>Institution</option>
                    <option value="dateOfQualification" {{ request('sort') == 'dateOfQualification' ? 'selected' : '' }}>Date</option>
                </select>
            </form>
        </div>

        {{-- Add Qualification Button --}}
        <div style="margin: 10px 0;">
            <a href="{{ route('qualification.create') }}" style="padding: 8px 12px; background-color: green; color: white; text-decoration: none; border-radius: 4px;">➕ Add Qualification</a>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto; border: 1px solid #ccc;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead style="background-color: #444; color: white;">
                    <tr>
                        <th style="padding: 8px; border: 1px solid #ccc;">ID</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Staff Name</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Qualification</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Institution</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Date</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($qualifications as $q)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $q->qualificationID }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $q->staff->name }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $q->qualificationType }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $q->institution }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $q->dateOfQualification }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">
                                <a href="{{ route('qualification.edit', $q->qualificationID) }}" style="color: blue; text-decoration: underline; margin-right: 10px;">Edit</a>
                                <form method="POST" action="{{ route('qualification.destroy', $q->qualificationID) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this qualification?')" style="color: red; background: none; border: none; text-decoration: underline; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 12px; color: gray;">No qualifications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 20px;">
            {{ $qualifications->links() }}
        </div>
    </div>
</x-app-layout>
