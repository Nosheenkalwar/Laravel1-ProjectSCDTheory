<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Add Product
            </a>
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
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 whitespace-nowrap break-words text-sm">{{ $product->id }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    @if($product->img)
                                        <img src="{{ asset('storage/'.$product->img) }}" class="w-12 h-12 sm:w-16 sm:h-16 object-cover rounded" alt="{{ $product->name }}">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-3 py-2 whitespace-normal break-words text-sm">{{ $product->name }}</td>
                                <td class="px-3 py-2 whitespace-normal break-words text-sm">{{ $product->category }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm">{{ number_format($product->price, 2) }}</td>
                                <td class="px-3 py-2 whitespace-normal break-words max-h-24 overflow-y-auto text-sm">{{ $product->description ?? 'N/A' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap flex flex-col sm:flex-row gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-center text-sm">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-center text-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-4 text-center text-gray-500 text-sm">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4 px-3 py-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
