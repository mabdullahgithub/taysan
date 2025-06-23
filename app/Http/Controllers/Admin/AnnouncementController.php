<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $announcements = Announcement::orderBy('order')->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.announcements.index', compact('announcements'));
        } catch (\Exception $e) {
            Log::error('Error loading announcements: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load announcements.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:sale,announcement,countdown,product_launch,event',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'countdown_date' => 'nullable|date',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
            'display_duration' => 'integer|min:1000',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['order'] = $data['order'] ?? 0;
        $data['display_duration'] = $data['display_duration'] ?? 5000;
        $data['background_color'] = $data['background_color'] ?? '#8B7BA8';
        $data['text_color'] = $data['text_color'] ?? '#FFFFFF';
        $data['type'] = $data['type'] ?? 'announcement';

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
            $data['image'] = $imagePath;
        }

        Announcement::create($data);

        return redirect()->route('admin.announcements.index')
                        ->with('success', 'Announcement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:sale,announcement,countdown,product_launch,event',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'countdown_date' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
            'display_duration' => 'nullable|integer|min:1000',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['order'] = $data['order'] ?? 0;
        $data['display_duration'] = $data['display_duration'] ?? 5000;

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            $data['image'] = null;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if replacing
            if ($announcement->image && !$request->has('remove_image')) {
                Storage::disk('public')->delete($announcement->image);
            }
            
            $imagePath = $request->file('image')->store('announcements', 'public');
            $data['image'] = $imagePath;
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
                        ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        // Delete image if exists
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
                        ->with('success', 'Announcement deleted successfully.');
    }

    /**
     * Toggle announcement status
     */
    public function toggleStatus(Announcement $announcement)
    {
        try {
            $announcement->update(['is_active' => !$announcement->is_active]);
            
            $status = $announcement->is_active ? 'activated' : 'deactivated';
            
            // For AJAX requests, return JSON response
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'is_active' => $announcement->is_active,
                    'status' => $announcement->status,
                    'status_color' => $announcement->status_color,
                    'message' => "Announcement {$status} successfully."
                ]);
            }
            
            return redirect()->back()->with('success', "Announcement {$status} successfully.");
        } catch (\Exception $e) {
            Log::error('Error toggling announcement status: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update announcement status.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to update announcement status.');
        }
    }

    /**
     * Toggle all announcements status
     */
    public function toggleAllStatus(Request $request)
    {
        try {
            $request->validate([
                'status' => 'required|boolean'
            ]);

            $status = $request->status;
            $count = Announcement::query()->update(['is_active' => $status]);
            
            $action = $status ? 'enabled' : 'disabled';
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                    'status' => $status,
                    'message' => "{$count} announcements {$action} successfully."
                ]);
            }
            
            return redirect()->back()->with('success', "{$count} announcements {$action} successfully.");
        } catch (\Exception $e) {
            Log::error('Error toggling all announcements: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update announcements.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to update announcements.');
        }
    }
}
