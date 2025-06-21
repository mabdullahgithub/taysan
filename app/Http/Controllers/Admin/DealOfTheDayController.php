<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DealOfTheDay;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DealOfTheDayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deals = DealOfTheDay::with('product')->orderBy('sort_order')->latest()->get();
        $products = Product::where('status', 'active')->get();
        
        return view('admin.deals.index', compact('deals', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'deal_price' => 'nullable|numeric|min:0',
            'deal_title' => 'nullable|string|max:255',
            'deal_description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer'
        ]);

        try {
            DB::beginTransaction();

            // Check if product already has an active deal
            $existingDeal = DealOfTheDay::where('product_id', $validated['product_id'])
                                      ->active()
                                      ->first();

            if ($existingDeal) {
                return redirect()->back()
                    ->with('error', 'This product already has an active deal.');
            }

            $validated['is_active'] = $request->has('is_active');
            $validated['sort_order'] = $validated['sort_order'] ?? 0;

            DealOfTheDay::create($validated);
            
            DB::commit();

            return redirect()->route('admin.deals.index')
                ->with('success', 'Deal created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create deal', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Failed to create deal. Please try again.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DealOfTheDay $deal)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'deal_price' => 'nullable|numeric|min:0',
            'deal_title' => 'nullable|string|max:255',
            'deal_description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer'
        ]);

        try {
            DB::beginTransaction();

            // Check if another product has an active deal (exclude current deal)
            $existingDeal = DealOfTheDay::where('product_id', $validated['product_id'])
                                      ->where('id', '!=', $deal->id)
                                      ->active()
                                      ->first();

            if ($existingDeal) {
                return redirect()->back()
                    ->with('error', 'This product already has another active deal.');
            }

            $validated['is_active'] = $request->has('is_active');
            $validated['sort_order'] = $validated['sort_order'] ?? 0;

            $deal->update($validated);
            
            DB::commit();

            return redirect()->route('admin.deals.index')
                ->with('success', 'Deal updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update deal', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Failed to update deal. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DealOfTheDay $deal)
    {
        try {
            $dealTitle = $deal->deal_title ?: $deal->product->name;
            $deal->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Deal '{$dealTitle}' deleted successfully!"
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to delete deal', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete deal. Please try again.'
            ], 500);
        }
    }

    /**
     * Toggle deal status
     */
    public function toggleStatus(DealOfTheDay $deal)
    {
        try {
            $deal->update(['is_active' => !$deal->is_active]);
            
            return response()->json([
                'success' => true,
                'status' => $deal->is_active,
                'message' => 'Deal status updated successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to toggle deal status', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update deal status.'
            ], 500);
        }
    }
}
