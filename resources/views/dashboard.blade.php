<x-app-layout>
    <x-slot name="header">
        <!-- <div class="flex justify-between items-center">
            !-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2> --
        </div> -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex">
                    <div class="p-6 pb-0 text-gray-900 dark:text-gray-100">
                        @if (session('success'))
                            <p style="color:green;">{{ session('success') }}</p>
                        @endif
                        @if (session('error'))
                            <p style="color:red;">{{ session('error') }}</p>
                        @endif
                        @if (auth()->user()->role === 'super_admin')
                            <p>Welcome, Super Admin {{ auth()->user()->name }}!</p>
                        @endif

                        @if (auth()->user()->role === 'admin')
                            <p>Welcome, Admin {{ auth()->user()->name }}!</p>
                        @endif

                        @if (auth()->user()->role === 'user')
                            <p>Welcome, {{ auth()->user()->name }}!</p>
                        @endif
                    </div>
                    <div class="p-6 flex gap-1">
                        <form method="POST" action="{{ route('clock.in') }}" class="flex">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Clock In</button>
                        </form>

                        <form method="POST" action="{{ route('clock.out') }}" class="flex">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Clock Out</button>
                        </form>
                    </div>
                </div>
                <div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                            {{ auth()->user()->role == 'admin' ? 'All User Time Logs' : 'Your Time Logs' }}
                        </h2>

                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr>
                                    @if(auth()->user()->role == 'admin')
                                        <th class="border px-4 py-2">User</th>
                                    @endif
                                    <th class="border px-4 py-2">Clock In</th>
                                    <th class="border px-4 py-2">Clock Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($timeLogs as $log)
                                    <tr>
                                        @if(auth()->user()->role == 'admin')
                                            <td class="border px-4 py-2">{{ $log->user->name }}</td>
                                        @endif
                                        <td class="border px-4 py-2">{{ $log->clock_in_time }}</td>
                                        <td class="border px-4 py-2">
                                            {{ $log->clock_out_time ?? 'Still Clocked In' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ auth()->user()->role == 'admin' ? '3' : '2' }}" class="border px-4 py-2 text-center">
                                            No time logs found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <!-- Header -->
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                            Order Tracking Info
                        </h2>
                        <form method="GET" action="{{ route('products.index') }}" class="flex gap-2 w-[50%]">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search Title, Serial #, Tracking #, Tracing #, Module Location"
                                class="border-gray-300 text-gray-600 rounded-md shadow-sm w-[100%] px-3 py-2">

                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md">
                                Search
                            </button>

                            <a href="{{ route('dashboard') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white text-sm flex items-center px-4 py-2 rounded-md">
                                Reset
                            </a>
                        </form>
                    </div>
                    <!-- Tracking Info Table -->
                    <div class="overflow-x-auto">
                        <div x-data="productModal()">
                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left text-gray-700">
                                    <thead class="bg-gray-800 text-white">
                                        <tr>
                                            <th class="px-4 py-2">Tracking #</th>
                                            <th class="px-4 py-2">Title</th>
                                            <th class="px-4 py-2">Image</th>
                                            <th class="px-4 py-2">QTY</th>
                                            <th class="px-4 py-2">Price</th>
                                            <th class="px-4 py-2">Tracing #</th>
                                            <th class="px-4 py-2">Serial #</th>
                                            <th class="px-4 py-2">Module Location</th>
                                            <th class="px-4 py-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                            @forelse ($products as $product)
                                            <tr class="border-b">
                                                <td class="px-4 py-2 font-medium">{{ $product->tracking_number ?? 'N/A' }}</td>
                                                <td class="px-4 py-2">{{ $product->title }}</td>
                                                <td class="px-4 py-2">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                                            class="w-10 h-10 object-cover rounded">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2">{{ $product->quantity }}</td>
                                                <td class="px-4 py-2">${{ $product->price }}</td>
                                                <td class="px-4 py-2">{{ $product->tracing_number ?? '---' }}</td>
                                                <td class="px-4 py-2">{{ $product->serial_number ?? '---' }}</td>
                                                @php
                                                    switch ($product->module_location) {
                                                        case 'Order': $color = 'bg-blue-600'; break;
                                                        case 'Received': $color = 'bg-green-600'; break;
                                                        case 'Unreceived': $color = 'bg-yellow-600'; break;
                                                        case 'Labeling': $color = 'bg-purple-600'; break;
                                                        case 'Stockroom': $color = 'bg-gray-600'; break;
                                                        default: $color = 'bg-red-600'; break;
                                                    }
                                                @endphp

                                                <td class="px-4 py-2">
                                                    <span class="px-2 py-1 rounded text-white text-xs font-semibold {{ $color }}">
                                                        {{ $product->module_location }}
                                                    </span>
                                                </td>

                                                <td class="px-4 table-cell gap-1 py-2">
                                                    <div class="flex gap-1">
                                                        <button 
                                                            @click="openModal({ 
                                                                tracking_number: '{{ $product->tracking_number }}',
                                                                title: '{{ $product->title }}',
                                                                image: '{{ $product->image }}',
                                                                quantity: '{{ $product->quantity }}',
                                                                price: '{{ $product->price }}',
                                                                serial_number: '{{ $product->serial_number }}',
                                                                pcn: '{{ $product->pcn }}',
                                                                code_input: '{{ $product->code_input }}',
                                                                asin: '{{ $product->asin }}',
                                                                fnsku: '{{ $product->fnsku }}',
                                                                module_location: '{{ $product->module_location }}'
                                                            })"
                                                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                                            View
                                                        </button>

                                                        <a href="{{ route('products.edit', $product) }}"
                                                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="px-4 py-2 text-center">No products found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                        {{ $products->links() }}
                                </div>
                                @if(auth()->user()->role === 'admin')
                                    <div class="flex justify-end space-x-2 mt-4">
                                        <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Product</a>
                                    </div>
                                @endif
                            </div>
                            <!-- Modal -->
                            <div x-show="showModal" x-cloak x-transition
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/2">
                                    <h2 class="text-xl text-gray-800 font-semibold mb-4">Tracking Item Details</h2>

                                    <p class="text-gray-600"><strong>Tracking #:</strong> <span x-text="product.tracking_number"></span></p>
                                    <p class="text-gray-600"><strong>Title:</strong> <span x-text="product.title"></span></p>
                                    <div class="mb-4">
                                        <strong class="text-gray-600">Product Image:</strong><br>
                                        <template x-if="product.image">
                                            <img :src="'/storage/' + product.image"
                                                alt="Product Image"
                                                class="w-20 h-20 object-cover rounded mt-2">
                                        </template>
                                        <template x-if="!product.image">
                                            <span>No Image Available</span>
                                        </template>
                                    </div>
                                    <p class="text-gray-600"><strong>Quantity:</strong> <span x-text="product.quantity"></span></p>
                                    <p class="text-gray-600"><strong>Price:</strong> $<span x-text="product.price"></span></p>
                                    <p class="text-gray-600"><strong>Serial #:</strong> <span x-text="product.serial_number"></span></p>
                                    <p class="text-gray-600"><strong>PCN:</strong> <span x-text="product.pcn"></span></p>
                                    <p class="text-gray-600"><strong>Code Input:</strong> <span x-text="product.code_input"></span></p>
                                    <p class="text-gray-600"><strong>ASIN:</strong> <span x-text="product.asin"></span></p>
                                    <p class="text-gray-600"><strong>FNSKU:</strong> <span x-text="product.fnsku"></span></p>
                                    <p class="text-gray-600"><strong>Module Location:</strong> <span x-text="product.module_location"></span></p>

                                    <button @click="showModal = false"
                                            class="mt-6 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function productModal() {
            return {
                showModal: false,
                product: {},

                openModal(productData) {
                    this.product = productData;
                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                }
            }
        }
    </script>

</x-app-layout>
