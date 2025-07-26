<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // If search query is provided
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('serial_number', 'like', '%' . $search . '%')
                ->orWhere('tracking_number', 'like', '%' . $search . '%')
                ->orWhere('tracing_number', 'like', '%' . $search . '%')
                ->orWhere('module_location', 'like', '%' . $search . '%');
            });
        }

        // Apply order by module_location priority + latest created_at
        $query->orderByRaw("
            FIELD(module_location, 'Order', 'Received', 'Unreceived', 'Labeling', 'Stockroom')
        ")->orderBy('created_at', 'desc');

        // Finally, paginate:
        $products = $query->paginate(4)->withQueryString();
        
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tracking_number' => 'required|string|unique:products',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'tracing_number' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'module_location' => 'required|in:Order,Received,Unreceived,Labeling,Stockroom',
        ]);

        $validated['image'] = $this->handleImageUpload($request);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        // Optional: restrict to admin
        // if (auth()->user()->role !== 'admin') {
        //     abort(403, 'Unauthorized.');
        // }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Optional: restrict to admin
        // if (auth()->user()->role !== 'admin') {
        //     abort(403, 'Unauthorized.');
        // }

        $validated = $request->validate([
            'tracking_number' => 'required|string|unique:products,tracking_number,' . $product->id,
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'tracing_number' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'module_location' => 'required|in:Order,Received,Unreceived,Labeling,Stockroom',
        ]);

        $newImage = $this->handleImageUpload($request);
        if ($newImage) {
            $validated['image'] = $newImage;
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Optional: restrict to admin
        // if (auth()->user()->role !== 'admin') {
        //     abort(403, 'Unauthorized.');
        // }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Handle image upload and return stored path or null.
     */
    private function handleImageUpload(Request $request)
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('products', 'public');
        }
        return null;
    }

     public function showModuleProducts($module)
    {

        $moduleSlug = strtolower($module);

        $moduleMap = [
            'orders'      => 'Order',
            'received'    => 'Received',
            'unreceived'  => 'Order',
            'labeling'    => 'Labeling',
            'stockroom'   => 'Stockroom',
        ];

        if (!isset($moduleMap[$moduleSlug])) {
            abort(404);
        }

        $moduleLocation = $moduleMap[$moduleSlug];

        $products = Product::where('module_location', $moduleLocation)->latest()->get();

        return view('products.' . $moduleSlug, compact('products'));
    }

    public function updateModuleLocation(Request $request, Product $product)
    {
        $validated = $request->validate([
            'module_location' => 'required|in:Order,Received,Unreceived,Labeling,Stockroom',
        ]);

        $product->update([
            'module_location' => $validated['module_location'],
        ]);

        return back()->with('success', 'Module location updated successfully!');
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function saveTestResult(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->pcn = $request->pcn;
        $product->code_input = $request->code_input;
        $product->module_location = 'Labeling';
        $product->save();

        return response()->json(['message' => 'Saved successfully']);
    }

    public function saveLabelingData(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->asin = $request->asin;
        $product->fnsku = $request->fnsku;
        $product->module_location = 'Stockroom';
        $product->save();

        return response()->json(['message' => 'Labeling data saved successfully.']);
    }
   
}
