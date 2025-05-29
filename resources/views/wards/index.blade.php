<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Manage Wards</h2>
    </x-slot>

    <div style="padding: 20px;">

        {{-- Accordion Header --}}
        <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Ward List</div>

        {{-- Search and Sort --}}
        <div style="border: 1px solid #ccc; padding: 10px; border-top: none; display: flex; justify-content: space-between; align-items: center;">
            <form method="GET" action="{{ route('wards.index') }}" style="display: flex; gap: 10px; width: 100%;">
                <input type="text" name="search" placeholder="Search by name, location, staff" value="{{ request('search') }}"
                       style="padding: 5px; width: 40%; border: 1px solid #ccc;">
                <button type="submit" style="padding: 5px 10px; background-color: #444; color: white; border: none;">Search</button>

                <select name="sort" onchange="this.form.submit()" style="margin-left: auto; padding: 5px; border: 1px solid #ccc;">
                    <option value="">Sort</option>
                    <option value="wardName" {{ request('sort') == 'wardName' ? 'selected' : '' }}>Ward Name</option>
                    <option value="location" {{ request('sort') == 'location' ? 'selected' : '' }}>Location</option>
                    <option value="totalBeds" {{ request('sort') == 'totalBeds' ? 'selected' : '' }}>Total Beds</option>
                </select>
            </form>
        </div>

        {{-- Add Ward Button --}}
        <div style="margin: 10px 0;">
            <a href="{{ route('wards.create') }}" style="padding: 8px 12px; background-color: green; color: white; text-decoration: none; border-radius: 4px;">➕ Add Ward</a>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto; border: 1px solid #ccc;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead style="background-color: #444; color: white;">
                    <tr>
                        <th style="padding: 8px; border: 1px solid #ccc;">Ward ID</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Ward Name</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Location</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Total Beds</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Telephone</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Staff</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wards as $ward)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $ward->wardID }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $ward->wardName }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $ward->location }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $ward->totalBeds }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $ward->telExtension }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">
                                @forelse ($ward->staff as $staffMember)
                                    {{ optional($staffMember)->name }}@if (!$loop->last), @endif
                                @empty
                                    N/A
                                @endforelse
                            </td>
                            <td style="padding: 8px; border: 1px solid #ccc;">
                                <a href="{{ route('wards.edit', $ward->wardID) }}" style="color: blue; text-decoration: underline; margin-right: 10px;">Edit</a>
                                <form method="POST" action="{{ route('wards.destroy', $ward->wardID) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this ward?')" style="color: red; background: none; border: none; text-decoration: underline; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 12px; color: gray;">No wards found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 20px;">
            {{ $wards->links() }}
        </div>
    </div>
</x-app-layout>
