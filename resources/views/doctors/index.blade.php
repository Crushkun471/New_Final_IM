<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Manage Local Doctors</h2>
    </x-slot>

    <div style="padding: 20px;">
        <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Local Doctors List</div>

        <div style="border: 1px solid #ccc; padding: 10px; border-top: none; display: flex; justify-content: space-between; align-items: center;">
            <form method="GET" action="{{ route('doctors.index') }}" style="display: flex; gap: 10px; width: 100%;">
                <input type="text" name="search" placeholder="Search by name, address, phone" value="{{ request('search') }}"
                       style="padding: 5px; width: 40%; border: 1px solid #ccc;">
                <button type="submit" style="padding: 5px 10px; background-color: #444; color: white; border: none;">Search</button>
            </form>
        </div>

        <div style="margin: 10px 0;">
            <a href="{{ route('doctors.create') }}" style="padding: 8px 12px; background-color: green; color: white; text-decoration: none; border-radius: 4px;">➕ Add Doctor</a>
        </div>

        <div style="overflow-x: auto; border: 1px solid #ccc;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead style="background-color: #444; color: white;">
                    <tr>
                        <th style="padding: 8px; border: 1px solid #ccc;">ID</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Name</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Phone</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Address</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($doctors as $doc)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $doc->clinicID }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $doc->name }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $doc->phone }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $doc->address }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">
                                <a href="{{ route('doctors.edit', $doc->clinicID) }}" style="color: blue; text-decoration: underline; margin-right: 10px;">Edit</a>
                                <form method="POST" action="{{ route('doctors.destroy', $doc->clinicID) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this doctor?')" style="color: red; background: none; border: none; text-decoration: underline; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 12px; color: gray;">No doctors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">{{ $doctors->links() }}</div>
    </div>
</x-app-layout>
