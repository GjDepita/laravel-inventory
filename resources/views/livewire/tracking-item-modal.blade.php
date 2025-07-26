<div x-data="{ show: @entangle('show').defer }" x-cloak>
    <div x-show="show"
         x-transition
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/2">
            <h2 class="text-xl font-semibold mb-4">Tracking Item Details</h2>

            <!-- Static Example Data -->
            <p><strong>Tracking #:</strong> TRK12345</p>
            <p><strong>Title:</strong> Sample Product</p>
            <p><strong>Quantity:</strong> 5</p>
            <p><strong>Price:</strong> $150.00</p>
            <p><strong>Serial #:</strong> SERIAL00123</p>
            <p><strong>Module Location:</strong> Warehouse A</p>

            <button wire:click="closeModal"
                    class="mt-6 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                Close
            </button>
        </div>

    </div>
</div>
