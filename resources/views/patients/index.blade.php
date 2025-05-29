<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Manage Patient Information</h2>
    </x-slot>

    <div style="padding: 20px;">
        {{-- Accordion Header --}}
        <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Patient List</div>

        {{-- Search and Sort --}}
        <div style="border: 1px solid #ccc; padding: 10px; border-top: none; display: flex; justify-content: space-between; align-items: center;">
            <form method="GET" action="{{ route('patients.index') }}" style="display: flex; gap: 10px; width: 100%;">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                       style="padding: 5px; width: 30%; border: 1px solid #ccc;">
                <button type="submit" style="padding: 5px 10px; background-color: #444; color: white; border: none;">Search</button>

                <select name="sort" onchange="this.form.submit()" style="margin-left: auto; padding: 5px; border: 1px solid #ccc;">
                    <option value="">Sort</option>
                    <option value="fname" {{ request('sort') == 'fname' ? 'selected' : '' }}>First Name</option>
                    <option value="lname" {{ request('sort') == 'lname' ? 'selected' : '' }}>Last Name</option>
                </select>
            </form>
        </div>

        {{-- Add Patient Button --}}
        <div style="margin: 10px 0;">
            <a href="{{ route('patients.create') }}" style="padding: 8px 12px; background-color: green; color: white; text-decoration: none; border-radius: 4px;">➕ Add Patient</a>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto; border: 1px solid #ccc; border-top: none;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead style="background-color: #444; color: white;">
                    <tr>
                        <th style="padding: 8px; border: 1px solid #ccc;">Patient #</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Full Name</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Next of Kin</th>  {{-- New --}}
                        <th style="padding: 8px; border: 1px solid #ccc;">Sex</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Date of Birth</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Phone</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Address</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Marital Status</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Patient Type</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Date Registered</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $p)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $p->patientID }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $p->fname }} {{ $p->lname }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">
                                {{-- Show first kin's name or N/A --}}
                                {{ $p->kin->first() ? $p->kin->first()->name : 'N/A' }}
                            </td>
                            <td style="padding: 8px; border: 1px solid #ccc;">
                                @if ($p->sex === 'M') Male
                                @elseif ($p->sex === 'F') Female
                                @else {{ $p->sex }}
                                @endif
                            </td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ \Carbon\Carbon::parse($p->dateofbirth)->format('Y-m-d') }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $p->phone }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $p->address }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ $p->maritalstatus }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc; text-transform: capitalize;">{{ $p->patienttype }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">{{ \Carbon\Carbon::parse($p->dateregistered)->format('Y-m-d') }}</td>
                            <td style="padding: 8px; border: 1px solid #ccc;">
                                <a href="{{ route('patients.edit', $p->patientID) }}" style="color: blue; text-decoration: underline; margin-right: 10px;">Edit</a>
                                <form method="POST" action="{{ route('patients.destroy', $p->patientID) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this patient?')" style="color: red; background: none; border: none; text-decoration: underline; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="11" style="text-align: center; padding: 12px; color: gray;">No patients found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 20px;">
            {{ $patients->links() }}
        </div>
    </div>
</x-app-layout>
