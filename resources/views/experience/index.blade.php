<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Manage Staff Experience</h2>
    </x-slot>

    <div style="padding: 20px;">

        {{-- Accordion Header --}}
        <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Staff Experience List</div>

        {{-- Search and Sort --}}
        <div style="border: 1px solid #ccc; padding: 10px; border-top: none; display: flex; justify-content: space-between; align-items: center;">
            <form method="GET" action="{{ route('experience.index') }}" style="display: flex; gap: 10px; width: 100%;">
                <input type="text" name="search" placeholder="Search by name, organization, position" value="{{ request('search') }}"
                       style="padding: 5px; width: 40%; border: 1px solid #ccc;">
                <button type="submit" style="padding: 5px 10px; background-color: #444; color: white; border: none;">Search</button>

                <select name="sort" onchange="this.form.submit()" style="margin-left: auto; padding: 5px; border: 1px solid #ccc;">
                    <option value="">Sort</option>
                    <option value="organization" {{ request('sort') == 'organization' ? 'selected' : '' }}>Organization</option>
                    <option value="startDate" {{ request('sort') == 'startDate' ? 'selected' : '' }}>Start Date</option>
                    <option value="endDate" {{ request('sort') == 'endDate' ? 'selected' : '' }}>End Date</option>
                </select>
            </form>
        </div>

        {{-- Add Experience Button --}}
        <div style="margin: 10px 0;">
            <a href="{{ route('experience.create') }}" style="padding: 8px 12px; background-color: green; color: white; text-decoration: none; border-radius: 4px;">➕ Add Experience</a>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto; border: 1px solid #ccc;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead style="background-color: #444; color: white;">
                    <tr>
                        <th style="padding: 8px; border: 1px solid #ccc;">ID</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Staff Name</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Organization</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Position</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Start Date</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">End Date</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($experiences as $exp)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $exp->experienceID }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $exp->staff->name }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $exp->organization }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $exp->position }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $exp->startDate }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $exp->endDate ?? '-' }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">
                                <a href="{{ route('experience.edit', $exp->experienceID) }}" style="color: blue; text-decoration: underline; margin-right: 10px;">Edit</a>
                                <form method="POST" action="{{ route('experience.destroy', $exp->experienceID) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this experience?')" style="color: red; background: none; border: none; text-decoration: underline; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 12px; color: gray;">No experience records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 20px;">
            {{ $experiences->links() }}
        </div>
    </div>
</x-app-layout>
