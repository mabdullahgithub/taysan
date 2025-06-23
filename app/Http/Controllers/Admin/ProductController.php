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
        'detailed_description' => 'nullable|string',
        'price' => 'required|integer|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'additional_images' => 'nullable|array',
        'additional_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        'sku' => 'nullable|string|max:100',
        'weight' => 'nullable|numeric|min:0',
        'dimensions' => 'nullable|string|max:100',
        'ingredients' => 'nullable|string',
        'benefits' => 'nullable|string',
        'usage_instructions' => 'nullable|string',
        'origin_country' => 'nullable|string|max:100',
        'is_organic' => 'nullable|boolean',
        'is_vegan' => 'nullable|boolean',
        'is_cruelty_free' => 'nullable|boolean',
        'tags' => 'nullable|string',
        'flag' => 'nullable|string|in:All Items,New Arrivals,Featured,On Sale',
        'status' => 'required|string|in:active,inactive'
    ]);
    
    try {
        DB::beginTransaction();
        
        // Process tags - convert comma-separated string to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = null;
        }
        
        // Handle main image upload
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
        
        // Handle additional images upload
        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $timestamp = now()->format('Ymd_His');
                
                $cleanName = preg_replace('/[^A-Za-z0-9\-_]/', '', $originalName);
                $cleanName = substr($cleanName, 0, 50);
                
                $newFileName = $timestamp . '_' . $cleanName . '_' . ($index + 1) . '.' . $extension;
                $imagePath = $file->storeAs('products', $newFileName, 'public');
                $additionalImages[] = $imagePath;
            }
        }
        
        if (!empty($additionalImages)) {
            $validated['images'] = $additionalImages;
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
        'detailed_description' => 'nullable|string',
        'price' => 'required|integer|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'additional_images' => 'nullable|array',
        'additional_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        'sku' => 'nullable|string|max:100',
        'weight' => 'nullable|numeric|min:0',
        'dimensions' => 'nullable|string|max:100',
        'ingredients' => 'nullable|string',
        'benefits' => 'nullable|string',
        'usage_instructions' => 'nullable|string',
        'origin_country' => 'nullable|string|max:100',
        'is_organic' => 'nullable|boolean',
        'is_vegan' => 'nullable|boolean',
        'is_cruelty_free' => 'nullable|boolean',
        'tags' => 'nullable|string',
        'flag' => 'nullable|string|in:All Items,New Arrivals,Featured,On Sale',
        'status' => 'required|string|in:active,inactive'
    ]);

    try {
        DB::beginTransaction();

        $oldImagePath = $product->image;
        $oldAdditionalImages = $product->images;

        // Process tags - convert comma-separated string to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = null;
        }

        // Handle main image update
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

        // Handle additional images update
        if ($request->hasFile('additional_images')) {
            // Delete old additional images if they exist
            if ($oldAdditionalImages && is_array($oldAdditionalImages)) {
                foreach ($oldAdditionalImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            // Upload new additional images
            $additionalImages = [];
            foreach ($request->file('additional_images') as $index => $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $timestamp = now()->format('Ymd_His');
                
                $cleanName = preg_replace('/[^A-Za-z0-9\-_]/', '', $originalName);
                $cleanName = substr($cleanName, 0, 50);
                
                $newFileName = $timestamp . '_' . $cleanName . '_' . ($index + 1) . '.' . $extension;
                $imagePath = $file->storeAs('products', $newFileName, 'public');
                $additionalImages[] = $imagePath;
            }
            
            $validated['images'] = $additionalImages;
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
            $additionalImages = $product->images;

            // Delete main image
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            
            // Delete additional images
            if ($additionalImages && is_array($additionalImages)) {
                foreach ($additionalImages as $image) {
                    Storage::disk('public')->delete($image);
                }
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