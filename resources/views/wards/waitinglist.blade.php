<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Manage Waiting List</h2>
    </x-slot>

    <div style="padding: 20px;">

        {{-- Accordion Header --}}
        <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Waiting List</div>

        {{-- Search and Sort --}}
        <div style="border: 1px solid #ccc; padding: 10px; border-top: none; display: flex; justify-content: space-between; align-items: center;">
            <form method="GET" action="{{ route('waitinglist.index') }}" style="display: flex; gap: 10px; width: 100%;">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                       style="padding: 5px; width: 30%; border: 1px solid #ccc;">
                <button type="submit" style="padding: 5px 10px; background-color: #444; color: white; border: none;">Search</button>

                <select name="sort" onchange="this.form.submit()" style="margin-left: auto; padding: 5px; border: 1px solid #ccc;">
                    <option value="">Sort</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Date Added</option>
                </select>
            </form>
        </div>

        {{-- Add Button --}}
        <div style="margin: 10px 0;">
            <a href="{{ route('waitinglist.create') }}" style="padding: 8px 12px; background-color: green; color: white; text-decoration: none; border-radius: 4px;">➕ Add to Waiting List</a>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto; border: 1px solid #ccc; border-top: none;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead style="background-color: #444; color: white;">
                    <tr>
                        <th style="padding: 8px; border: 1px solid #ccc;">ID</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Patient Name</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Reason</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Requested Date</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Ward</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Status</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($waitingList as $entry)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $entry->id }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $entry->patient_name }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $entry->reason }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $entry->requested_date }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $entry->ward->wardName ?? '-' }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $entry->status }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">
                                <a href="{{ route('waitinglist.edit', $entry->id) }}" style="color: blue; text-decoration: underline; margin-right: 10px;">Edit</a>
                                <form method="POST" action="{{ route('waitinglist.destroy', $entry->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Remove this entry from the list?')" style="color: red; background: none; border: none; text-decoration: underline; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 12px; color: gray;">No entries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 20px;">
            {{ $waitingList->links() }}
        </div>
    </div>
</x-app-layout>
