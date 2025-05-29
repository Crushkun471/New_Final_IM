<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Suppliers</h2>
    </x-slot>

    <div class="py-4 px-6 max-w-5xl mx-auto">
        {{-- Search and Sort --}}
        <form method="GET" action="{{ route('suppliers.index') }}" class="flex gap-3 mb-4 items-center">
            <input
                type="text"
                name="search"
                placeholder="Search by Name or Address..."
                value="{{ request('search') }}"
                class="border rounded px-3 py-2 w-1/3"
            >
            <select name="sort" onchange="this.form.submit()" class="border rounded px-3 py-2 ml-auto">
                <option value="">Sort By</option>
                <option value="supplierName" {{ request('sort') == 'supplierName' ? 'selected' : '' }}>Name</option>
                <option value="telephone" {{ request('sort') == 'telephone' ? 'selected' : '' }}>Telephone</option>
            </select>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded">Search</button>
        </form>

        <div class="mb-4">
            <a href="{{ route('suppliers.create') }}" class="bg-green-600 text-white px-4 py-2 rounded inline-block">➕ Add Supplier</a>
        </div>

        <div class="overflow-x-auto border rounded">
            <table class="min-w-full text-sm text-left border-collapse border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2 border border-gray-600">#</th>
                        <th class="px-4 py-2 border border-gray-600">Supplier Name</th>
                        <th class="px-4 py-2 border border-gray-600">Address</th>
                        <th class="px-4 py-2 border border-gray-600">Telephone</th>
                        <th class="px-4 py-2 border border-gray-600">Fax</th>
                        <th class="px-4 py-2 border border-gray-600 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr class="border border-gray-300 hover:bg-gray-50">
                            <td class="px-4 py-2 border border-gray-300">{{ $supplier->supplierID }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $supplier->supplierName }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $supplier->address }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $supplier->telephone }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $supplier->fax }}</td>
                            <td class="px-4 py-2 border border-gray-300 text-center space-x-2">
                                <a href="{{ route('suppliers.edit', $supplier->supplierID) }}" class="text-blue-600 hover:underline">Edit</a>

                                <form action="{{ route('suppliers.destroy', $supplier->supplierID) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this supplier?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">No suppliers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $suppliers->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>