<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">Add Service</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Name</label>
                    <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Description</label>
                    <textarea name="description" class="w-full border rounded p-2">{{ old('description') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Price</label>
                    <input type="number" name="price" step="0.01" class="w-full border rounded p-2" value="{{ old('price') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Category</label>
                    <input type="text" name="category" class="w-full border rounded p-2" value="{{ old('category') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Image</label>
                    <input type="file" name="img" class="w-full border rounded p-2">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Service</button>
            </form>
        </div>
    </div>
</x-app-layout>
