<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThankYouCardController extends Controller
{
    /**
     * Display the thank you card creation form
     */
    public function index()
    {
        return view('admin.thank-you-cards.index');
    }

    /**
     * Show the card creation form
     */
    public function create()
    {
        return view('admin.thank-you-cards.create');
    }

    /**
     * Preview the card before printing
     */
    public function preview(Request $request)
    {
        $cardData = $request->validate([
            'card_type' => 'required|in:thank_you,offer,ticket,custom',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'message' => 'required|string',
            'customer_name' => 'nullable|string|max:255',
            'offer_code' => 'nullable|string|max:50',
            'offer_discount' => 'nullable|string|max:50',
            'ticket_number' => 'nullable|string|max:50',
            'card_color' => 'required|in:purple,blue,green,pink,orange,red,teal,indigo',
            'card_style' => 'required|in:modern,elegant,playful,professional',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('thank-you-cards', 'public');
            $cardData['image_path'] = $imagePath;
        }

        return view('admin.thank-you-cards.preview', compact('cardData'));
    }

    /**
     * Generate and display the thank you card for printing
     */
    public function print(Request $request)
    {
        $cardData = $request->all();
        
        // If there's an existing image path, use it
        if ($request->has('existing_image') && $request->existing_image) {
            $cardData['image_path'] = $request->existing_image;
        }

        return view('admin.thank-you-cards.print', compact('cardData'));
    }

    /**
     * Legacy method for backward compatibility
     */
    public function generate(Request $request)
    {
        return $this->preview($request);
    }
}