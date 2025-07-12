<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    /**
     * Display reviews for a specific product
     */
    public function index(Product $product, Request $request)
    {
        $sortBy = $request->get('sort', 'newest'); // newest, oldest, highest, lowest, helpful, likes
        
        $query = $product->approvedReviews();
        
        // Sort reviews
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('reviewed_at', 'asc');
                break;
            case 'highest':
                $query->orderBy('rating', 'desc');
                break;
            case 'lowest':
                $query->orderBy('rating', 'asc');
                break;
            case 'helpful':
                $query->orderByRaw('JSON_LENGTH(helpful_votes) DESC');
                break;
            case 'likes':
                $query->orderBy('likes_count', 'desc');
                break;
            default: // newest
                $query->orderBy('reviewed_at', 'desc');
                break;
        }
        
        $reviews = $query->paginate(10);
        
        // Get rating summary
        $ratingDistribution = $product->rating_distribution;
        $averageRating = $product->average_rating;
        $totalReviews = $product->reviews_count;
        
        return response()->json([
            'reviews' => $reviews,
            'rating_distribution' => $ratingDistribution,
            'average_rating' => $averageRating,
            'total_reviews' => $totalReviews,
            'formatted_rating' => $product->formatted_rating
        ]);
    }
    
    /**
     * Verify order for review eligibility
     */
    public function verifyOrder(Request $request, Product $product)
    {
        Log::info('Order verification attempt', [
            'product_id' => $product->id,
            'request_data' => $request->all()
        ]);

        $request->validate([
            'order_id' => 'required|string|size:8|regex:/^[0-9]{8}$/'
        ], [
            'order_id.size' => 'Order ID must be exactly 8 digits.',
            'order_id.regex' => 'Order ID must contain only numbers.'
        ]);

        $orderNumber = $request->order_id;

        // Find the order by order number
        $order = Order::where('order_number', $orderNumber)->first();
        
        if (!$order) {
            Log::warning('Order not found during verification', [
                'order_number' => $orderNumber,
                'product_id' => $product->id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid Order ID. Please check your order ID and try again. Make sure you\'re using the correct 8-digit order number from your order confirmation.'
            ]);
        }

        // Check if a review already exists for this order and product
        $existingReview = Review::where('order_reference', $orderNumber)
                               ->where('product_id', $product->id)
                               ->first();

        if ($existingReview) {
            Log::warning('Duplicate review detected during verification', [
                'order_number' => $orderNumber,
                'product_id' => $product->id,
                'existing_review_id' => $existingReview->id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product with order ID ' . $orderNumber . '. Each order can only be used once per product review.'
            ]);
        }

        // Get order items with product details
        $orderItems = $order->orderItems()->with('product')->get();
        
        // Check which products have already been reviewed for this order
        $reviewedProductIds = Review::where('order_reference', $orderNumber)
                                   ->pluck('product_id')
                                   ->toArray();
        
        // Prepare order items data with review status
        $orderItemsData = $orderItems->map(function ($item) use ($reviewedProductIds) {
            return [
                'id' => $item->product->id,
                'name' => $item->product->name,
                'image' => $item->product->image_url,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'already_reviewed' => in_array($item->product->id, $reviewedProductIds)
            ];
        });

        Log::info('Order verification successful', [
            'order_number' => $orderNumber,
            'product_id' => $product->id,
            'order_items_count' => $orderItems->count()
        ]);

        return response()->json([
            'success' => true,
            'order_id' => $orderNumber,
            'order_items' => $orderItemsData,
            'message' => 'Order verified successfully! You can now write reviews for all products in this order.'
        ]);
    }

    /**
     * Store new reviews for multiple products from an order
     */
    public function store(Request $request, Product $product)
    {
        // Log the incoming request for debugging
        Log::info('Multi-product review submission attempt', [
            'request_data' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'nullable|string|max:255',
            'order_reference' => 'required|string|size:8|regex:/^[0-9]{8}$/',
            'reviews' => 'required|array|min:1',
            'reviews.*.product_id' => 'required|integer|exists:products,id',
            'reviews.*.rating' => 'required|integer|min:1|max:5',
            'reviews.*.title' => 'required|string|max:255',
            'reviews.*.comment' => 'required|string|min:10|max:1000'
        ], [
            'order_reference.size' => 'Order ID must be exactly 8 digits.',
            'order_reference.regex' => 'Order ID must contain only numbers.',
            'reviews.*.comment.min' => 'Each review comment must be at least 10 characters.',
            'reviews.*.rating.required' => 'Rating is required for each product.',
            'reviews.*.title.required' => 'Title is required for each product.',
            'reviews.*.comment.required' => 'Comment is required for each product.'
        ]);
        
        if ($validator->fails()) {
            Log::warning('Multi-product review validation failed', [
                'errors' => $validator->errors()->toArray(),
                'input' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $orderReference = $request->order_reference;
        
        // Find the order by order number
        $order = Order::where('order_number', $orderReference)->first();
        
        if (!$order) {
            Log::warning('Order not found for multi-product reviews', [
                'order_reference' => $orderReference
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid Order ID. Please check your order ID and try again.'
            ], 422);
        }

        // Get order items to verify products belong to this order
        $orderProductIds = $order->orderItems()->pluck('product_id')->toArray();
        
        $createdReviews = [];
        $skippedReviews = [];
        $errors = [];

        foreach ($request->reviews as $reviewData) {
            $productId = $reviewData['product_id'];
            
            // Check if product is in the order
            if (!in_array($productId, $orderProductIds)) {
                $errors[] = "Product ID {$productId} is not part of order {$orderReference}";
                continue;
            }
            
            // Check if review already exists for this product and order
            $existingReview = Review::where('product_id', $productId)
                ->where('order_reference', $orderReference)
                ->first();
                
            if ($existingReview) {
                $product = Product::find($productId);
                $skippedReviews[] = $product ? $product->name : "Product ID {$productId}";
                continue;
            }
            
            try {
                $review = Review::create([
                    'product_id' => $productId,
                    'name' => $request->name,
                    'email' => $request->email,
                    'location' => $request->location,
                    'rating' => $reviewData['rating'],
                    'title' => $reviewData['title'],
                    'comment' => $reviewData['comment'],
                    'order_reference' => $request->order_reference,
                    'is_verified_buyer' => true,
                    'is_approved' => false,
                    'reviewed_at' => now()
                ]);
                
                $createdReviews[] = $review;
                
                Log::info('Review created for product', [
                    'review_id' => $review->id,
                    'product_id' => $productId,
                    'order_reference' => $orderReference
                ]);
                
            } catch (\Exception $e) {
                Log::error('Failed to create review for product', [
                    'product_id' => $productId,
                    'order_reference' => $orderReference,
                    'error' => $e->getMessage()
                ]);
                
                $errors[] = "Failed to create review for product ID {$productId}";
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => 'Some reviews could not be created: ' . implode(', ', $errors)
            ], 422);
        }

        $message = count($createdReviews) . ' review(s) submitted successfully!';
        if (!empty($skippedReviews)) {
            $message .= ' Some products were skipped as they were already reviewed: ' . implode(', ', $skippedReviews);
        }

        Log::info('Multi-product reviews created successfully', [
            'total_created' => count($createdReviews),
            'total_skipped' => count($skippedReviews),
            'order_reference' => $orderReference
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
            'created_reviews' => count($createdReviews),
            'skipped_reviews' => count($skippedReviews)
        ]);
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid Order ID. Please check your order ID and try again. Make sure you\'re using the correct 8-digit order number from your order confirmation.'
            ], 422);
        }

        // Check if user already reviewed this product with this order
        $existingReview = Review::where('product_id', $product->id)
            ->where('order_reference', $orderReference)
            ->first();
            
        if ($existingReview) {
            Log::warning('Duplicate review attempt', [
                'order_reference' => $orderReference,
                'product_id' => $product->id,
                'existing_review_id' => $existingReview->id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product with order ID ' . $orderReference . '. Each order can only be used once per product review.'
            ], 422);
        }
        
        try {
            $review = Review::create([
                'product_id' => $product->id,
                'name' => $request->name,
                'email' => $request->email,
                'location' => $request->location,
                'rating' => $request->rating,
                'title' => $request->title,
                'comment' => $request->comment,
                'order_reference' => $request->order_reference,
                'is_verified_buyer' => true, // Always true since order is validated
                'is_approved' => false, // Require admin approval
                'reviewed_at' => now()
            ]);
            
            Log::info('Review created successfully', [
                'review_id' => $review->id,
                'product_id' => $product->id,
                'order_reference' => $orderReference
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your review! It will be published after moderation.',
                'review' => $review
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error creating review', [
                'error' => $e->getMessage(),
                'product_id' => $product->id,
                'order_reference' => $orderReference
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving your review. Please try again.'
            ], 500);
        }
    }
    
    /**
     * Toggle helpful vote for a review
     */
    public function toggleHelpful(Request $request, Review $review)
    {
        $userId = $request->ip(); // Use IP as user identifier for anonymous users
        
        $helpfulCount = $review->toggleHelpfulVote($userId);
        
        return response()->json([
            'success' => true,
            'helpful_count' => $helpfulCount,
            'is_helpful' => $review->isHelpfulForUser($userId)
        ]);
    }

    /**
     * Toggle like for a review
     */
    public function toggleLike(Request $request, Review $review)
    {
        $ip = $request->ip();
        
        $result = $review->toggleLike($ip);
        
        return response()->json([
            'success' => true,
            'liked' => $result['liked'],
            'likes_count' => $result['likes_count']
        ]);
    }
    
    /**
     * Get review form data
     */
    public function getFormData(Product $product)
    {
        return response()->json([
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image_url
            ],
            'countries' => [
                'United States',
                'Canada',
                'United Kingdom', 
                'Australia',
                'New Zealand',
                'Germany',
                'France',
                'Other'
            ]
        ]);
    }
}
