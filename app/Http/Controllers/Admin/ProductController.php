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
        'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
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
        'flag' => 'nullable|string|in:All Items,New Arrivals,Featured,On Sale,Best Seller,new',
        'status' => 'required|string|in:active,inactive'
    ], [
        'price.regex' => 'Price must be a valid number with up to 2 decimal places.',
        'price.numeric' => 'Price must be a valid number.',
        'price.min' => 'Price must be greater than or equal to 0.'
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
        
        // Ensure price is properly formatted as decimal
        $validated['price'] = number_format((float) $validated['price'], 2, '.', '');

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
        'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        'stock' => 'required|integer|min:0',
        'images' => 'nullable|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        'removed_images' => 'nullable|string',
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
        'flag' => 'nullable|string|in:All Items,New Arrivals,Featured,On Sale,Best Seller,new',
        'status' => 'required|string|in:active,inactive'
    ], [
        'price.regex' => 'Price must be a valid number with up to 2 decimal places.',
        'price.numeric' => 'Price must be a valid number.',
        'price.min' => 'Price must be greater than or equal to 0.'
    ]);

    try {
        DB::beginTransaction();

        // Get existing images - properly handle the images field
        $currentImages = [];
        if ($product->images) {
            if (is_string($product->images)) {
                $currentImages = json_decode($product->images, true) ?: [];
            } elseif (is_array($product->images)) {
                $currentImages = $product->images;
            }
        }

        // Process tags - convert JSON string to array if needed
        if (!empty($validated['tags'])) {
            $tagsData = json_decode($validated['tags'], true);
            if (is_array($tagsData)) {
                $validated['tags'] = $tagsData;
            } else {
                $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
            }
        } else {
            $validated['tags'] = null;
        }

        // Handle boolean values properly
        $validated['is_organic'] = $request->has('is_organic') ? (bool) $request->input('is_organic') : false;
        $validated['is_vegan'] = $request->has('is_vegan') ? (bool) $request->input('is_vegan') : false;
        $validated['is_cruelty_free'] = $request->has('is_cruelty_free') ? (bool) $request->input('is_cruelty_free') : false;

        // Handle removed images
        $removedImageIndices = [];
        if ($request->has('removed_images') && !empty($request->input('removed_images'))) {
            $removedImagesStr = $request->input('removed_images');
            $removedImageIndices = array_map('intval', explode(',', $removedImagesStr));
        }

        // Filter out removed images and delete their files
        $remainingImages = [];
        foreach ($currentImages as $index => $imagePath) {
            if (in_array($index, $removedImageIndices)) {
                // Delete the removed image file
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            } else {
                $remainingImages[] = $imagePath;
            }
        }

        // Handle new images upload
        $newImagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $timestamp = now()->format('Ymd_His');
                
                $cleanName = preg_replace('/[^A-Za-z0-9\-_]/', '', $originalName);
                $cleanName = substr($cleanName, 0, 50);
                
                $newFileName = $timestamp . '_' . $cleanName . '_' . ($index + 1) . '.' . $extension;
                $imagePath = $file->storeAs('products', $newFileName, 'public');
                $newImagesPaths[] = $imagePath;
            }
        }

        // Combine remaining and new images
        $finalImages = array_merge($remainingImages, $newImagesPaths);
        $validated['images'] = !empty($finalImages) ? $finalImages : null;

        // Set main image as first image if no main image exists
        if (empty($product->image) && !empty($finalImages)) {
            $validated['image'] = $finalImages[0];
        }

        // Ensure price is properly formatted as decimal
        $validated['price'] = number_format((float) $validated['price'], 2, '.', '');

        $product->update($validated);
        DB::commit();

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->name}' updated successfully!");
            
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Product update failed: ' . $e->getMessage());
        return redirect()->back()
            ->withInput()
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