<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Product
        </h2> -->
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                @if ($errors->any())
                    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tracking Number</label>
                        <input type="text" name="tracking_number" value="{{ old('tracking_number', $product->tracking_number) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Title</label>
                        <input type="text" name="title" value="{{ old('title', $product->title) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Image</label>
                        <input type="file" name="image" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @if ($product->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="h-20">
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Quantity</label>
                        <input type="number" name="quantity" min="0" value="{{ old('quantity', $product->quantity) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Price (₱)</label>
                        <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tracing Number</label>
                        <input type="text" name="tracing_number" value="{{ old('tracing_number', $product->tracing_number) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Serial Number</label>
                        <input type="text" name="serial_number" value="{{ old('serial_number', $product->serial_number) }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4 hidden">
                        <label class="block font-medium text-sm text-gray-700">Module Location</label>
                        <select name="module_location" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                            <option value="Order" {{ old('module_location', $product->module_location) == 'Order' ? 'selected' : '' }}>Received</option>
                            <option value="Received" {{ old('module_location', $product->module_location) == 'Received' ? 'selected' : '' }}>Received</option>
                            <option value="Unreceived" {{ old('module_location', $product->module_location) == 'Unreceived' ? 'selected' : '' }}>Unreceived</option>
                            <option value="Labeling" {{ old('module_location', $product->module_location) == 'Labeling' ? 'selected' : '' }}>Labeling</option>
                            <option value="Stockroom" {{ old('module_location', $product->module_location) == 'Stockroom' ? 'selected' : '' }}>Stockroom</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-md">
                            Back
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
