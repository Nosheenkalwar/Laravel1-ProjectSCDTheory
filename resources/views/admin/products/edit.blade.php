<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Edit Product
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">

            <form action="{{ route('admin.products.update', $product->id) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Product Name</label>
                    <input type="text" name="name"
                           class="w-full border rounded p-2"
                           value="{{ $product->name }}" required>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Description</label>
                    <textarea name="description"
                              class="w-full border rounded p-2"
                              rows="4">{{ $product->description }}</textarea>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Price (Rs)</label>
                    <input type="number" name="price" step="0.01"
                           class="w-full border rounded p-2"
                           value="{{ $product->price }}" required>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Category</label>
                    <input type="text" name="category"
                           class="w-full border rounded p-2"
                           value="{{ $product->category }}" required>
                </div>

                <!-- Existing Image -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Current Image</label>
                    <img src="{{ asset('images/' . $product->img) }}"
                         width="100" class="rounded mb-2">
                </div>

                <!-- Upload New Image -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Change Image (optional)</label>
                    <input type="file" name="img"
                           class="w-full border rounded p-2">
                </div>

                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-600">
                    Update Product
                </button>
            </form>

        </div>

    </div>
</x-app-layout>
