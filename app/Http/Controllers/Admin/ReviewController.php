<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(Request $request)
    {
        $query = Review::with('product');
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }
        
        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%");
            });
        }
        
        $reviews = $query->latest()->paginate(20);
        $products = Product::select('id', 'name')->get();
        
        // Statistics
        $stats = [
            'total' => Review::count(),
            'approved' => Review::where('is_approved', true)->count(),
            'pending' => Review::where('is_approved', false)->count(),
            'verified_buyers' => Review::where('is_verified_buyer', true)->count(),
        ];
        
        return view('admin.reviews.index', compact('reviews', 'products', 'stats'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create()
    {
        $products = Product::select('id', 'name')->get();
        return view('admin.reviews.create', compact('products'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
            'order_reference' => 'nullable|string|max:255',
            'is_verified_buyer' => 'boolean',
            'is_approved' => 'boolean'
        ]);
        
        Review::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'order_reference' => $request->order_reference,
            'is_verified_buyer' => $request->boolean('is_verified_buyer'),
            'is_approved' => $request->boolean('is_approved'),
            'reviewed_at' => now()
        ]);
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        $review->load('product');
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        $products = Product::select('id', 'name')->get();
        return view('admin.reviews.edit', compact('review', 'products'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
            'order_reference' => 'nullable|string|max:255',
            'is_verified_buyer' => 'boolean',
            'is_approved' => 'boolean'
        ]);
        
        $review->update([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'order_reference' => $request->order_reference,
            'is_verified_buyer' => $request->boolean('is_verified_buyer'),
            'is_approved' => $request->boolean('is_approved')
        ]);
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
    
    /**
     * Toggle review approval status
     */
    public function toggleApproval(Review $review)
    {
        $review->update([
            'is_approved' => !$review->is_approved
        ]);
        
        $status = $review->is_approved ? 'approved' : 'unapproved';
        
        return back()->with('success', "Review {$status} successfully.");
    }
    
    /**
     * Bulk approve reviews
     */
    public function bulkApprove(Request $request)
    {
        $reviewIds = $request->review_ids;
        
        if (!$reviewIds) {
            return back()->with('error', 'No reviews selected.');
        }
        
        // Convert comma-separated string to array
        if (is_string($reviewIds)) {
            $reviewIds = explode(',', $reviewIds);
        }
        
        $reviewIds = array_filter($reviewIds); // Remove empty values
        
        if (empty($reviewIds)) {
            return back()->with('error', 'No valid reviews selected.');
        }
        
        Review::whereIn('id', $reviewIds)->update(['is_approved' => true]);
        
        return back()->with('success', count($reviewIds) . ' reviews approved successfully.');
    }
    
    /**
     * Bulk delete reviews
     */
    public function bulkDelete(Request $request)
    {
        $reviewIds = $request->review_ids;
        
        if (!$reviewIds) {
            return back()->with('error', 'No reviews selected.');
        }
        
        // Convert comma-separated string to array
        if (is_string($reviewIds)) {
            $reviewIds = explode(',', $reviewIds);
        }
        
        $reviewIds = array_filter($reviewIds); // Remove empty values
        
        if (empty($reviewIds)) {
            return back()->with('error', 'No valid reviews selected.');
        }
        
        Review::whereIn('id', $reviewIds)->delete();
        
        return back()->with('success', count($reviewIds) . ' reviews deleted successfully.');
    }
}
