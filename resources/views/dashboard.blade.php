<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome to Well Meadows Hospital
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                <h3 class="text-2xl font-bold text-gray-700 mb-4">Hello, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-600 text-lg">
                    Welcome to the Well Meadows Hospital Management System. Use the navigation menu to manage staff, patients, medications, suppliers, and ward requisitions.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
