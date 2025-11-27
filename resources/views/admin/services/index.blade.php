<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Services</h2>
            <a href="{{ route('admin.services.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Add Service</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

             @if(session('success'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3500)"
                    x-show="show"
                    class="mb-4 text-center text-green-600 font-semibold transition-all duration-500"
                >
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($services as $service)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-sm">{{ $service->id }}</td>
                                <td class="px-3 py-2">
                                    @if($service->img)
                                        <img src="{{ asset('storage/'.$service->img) }}" class="w-12 h-12 object-cover rounded">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-sm">{{ $service->name }}</td>
                                <td class="px-3 py-2 text-sm">{{ $service->category }}</td>
                                <td class="px-3 py-2 text-sm">{{ number_format($service->price,2) }}</td>
                                <td class="px-3 py-2 text-sm">{{ $service->description ?? 'N/A' }}</td>
                                <td class="px-3 py-2 flex gap-2">
                                    <a href="{{ route('admin.services.edit', $service->id) }}" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Edit</a>
                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-gray-500 py-4">No services found.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4 px-3 py-4">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
