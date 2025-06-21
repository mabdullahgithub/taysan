<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();
        
        return view('admin.products.view', compact('products', 'categories'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'flag' => 'nullable|string|in:All Items,New Arrivals,Featured,On Sale',
        'status' => 'required|string|in:active,inactive'
    ]);
    
    try {
        DB::beginTransaction();
        
        if ($request->hasFile('image')) {
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $timestamp = now()->format('Ymd_His');
            
            // Clean the original name (remove special characters)
            $cleanName = preg_replace('/[^A-Za-z0-9\-_]/', '', $originalName);
            $cleanName = substr($cleanName, 0, 50); // Limit length
            
            // Create custom filename: timestamp_cleanname.extension
            $newFileName = $timestamp . '_' . $cleanName . '.' . $extension;
            
            // Store with custom filename
            $imagePath = $request->file('image')->storeAs('products', $newFileName, 'public');
            $validated['image'] = $imagePath;
        }
        
        $product = Product::create($validated);
        DB::commit();

        Log::info('Product created successfully', [
            'product_id' => $product->id,
            'name' => $product->name,
            'user_id' => auth()->id(),
            'image_path' => $validated['image'] ?? null
        ]);
        
        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->name}' created successfully!");
            
    } catch (\Exception $e) {
        DB::rollBack();
        
        Log::error('Failed to create product', [
            'error' => $e->getMessage(),
            'user_id' => auth()->id(),
            'request_data' => $request->except(['image'])
        ]);
        
        return redirect()->route('admin.products.index')
            ->with('error', 'Failed to create product. Please try again.');
    }
}

   public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'flag' => 'nullable|string|in:All Items,New Arrivals,Featured,On Sale',
        'status' => 'required|string|in:active,inactive'
    ]);

    try {
        DB::beginTransaction();

        $oldImagePath = $product->image;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($oldImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }
            
            // Create new custom filename
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $timestamp = now()->format('Ymd_His');
            $cleanName = preg_replace('/[^A-Za-z0-9\-_]/', '', $originalName);
            $cleanName = substr($cleanName, 0, 50);
            
            $newFileName = $timestamp . '_' . $cleanName . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('products', $newFileName, 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);
        DB::commit();

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->name}' updated successfully!");
            
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('admin.products.index')
            ->with('error', 'Failed to update product. Please try again.');
    }
}

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            $productName = $product->name;
            $imagePath = $product->image;

            // Delete associated image
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            // Delete the product
            $product->delete();

            DB::commit();

            Log::info('Product deleted successfully', [
                'product_id' => $product->id,
                'name' => $productName,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.products.index')
                ->with('success', "Product '{$productName}' deleted successfully!");
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to delete product', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            return redirect()->route('admin.products.index')
                ->with('error', 'Failed to delete product. Please try again.');
        }
    }

    public function edit(Product $product)
    {
        $product->load('category');
        
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    /**
     * Toggle product status (active/inactive)
     */
    public function toggleStatus(Product $product)
    {
        try {
            // Toggle between 'active' and 'inactive'
            $newStatus = $product->status === 'active' ? 'inactive' : 'active';
            $product->update(['status' => $newStatus]);
            
            $status = $product->status === 'active' ? 'activated' : 'deactivated';
            
            Log::info("Product status changed", [
                'product_id' => $product->id,
                'new_status' => $product->status,
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => "Product {$status} successfully!",
                'new_status' => $product->status
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to toggle product status', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status'
            ], 500);
        }
    }

    /**
     * Get product details for viewing
     */
    public function show(Product $product)
    {
        $product->load('category');
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'status' => $product->status,
                'category' => $product->category->name,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
                'created_at' => $product->created_at->format('M d, Y h:i A'),
                'updated_at' => $product->updated_at->format('M d, Y h:i A')
            ]
        ]);
    }
    public function create()
{
    $categories = Category::all();
    return view('admin.products.create', compact('categories'));
}


}