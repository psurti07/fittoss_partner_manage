<?php

namespace Modules\Testimonial\App\Http\Controllers;

use App\DataTables\TestimonialDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Testimonial\App\Models\TestiMonial;
use Illuminate\Support\Facades\Log;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TestimonialDataTable $datatable)
    {
        return $datatable->render('testimonial::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('testimonial::modals.addTestimonial');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:1,2,3',
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'address' => 'required|string|max:255',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string',
        ]);

        try {
            Log::info('Storing new testimonial', ['data' => $validated]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'-'.$image->getClientOriginalName();
                $destinationPath = public_path('assets/images/testimonial');
                $image->move($destinationPath, $imageName);
                $imagePath = 'assets/images/testimonial/'.$imageName;

                Log::info('Image uploaded', ['path' => $imagePath]);
            }

            TestiMonial::create([
                'type' => $validated['type'],
                'name' => $validated['name'],
                'image' => $imagePath,
                'address' => $validated['address'],
                'rating' => $validated['rating'],
                'review' => $validated['review'],
            ]);

            Log::info('Testimonial created successfully');

            return response()->json(['type' => 'success', 'message' => 'Testimonial added successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Error creating testimonial', ['error' => $e->getMessage()]);
            return response()->json(['type' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('testimonial::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = TestiMonial::findOrFail($id);

        return view('testimonial::modals.editTestimonial', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|in:1,2,3',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'address' => 'required|string|max:255',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string',
        ]);

        try {
            $testimonial = Testimonial::findOrFail($id);

            Log::info("Updating testimonial ID: $id", ['data' => $validated]);

            $imagePath = $testimonial->image;
            if ($request->hasFile('image')) {
                if ($imagePath && file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                    Log::info('Old image deleted', ['path' => $imagePath]);
                }

                $image = $request->file('image');
                $imageName = time().'-'.$image->getClientOriginalName();
                $destinationPath = public_path('assets/images/testimonial');
                $image->move($destinationPath, $imageName);
                $imagePath = 'assets/images/testimonial/'.$imageName;

                Log::info('New image uploaded', ['path' => $imagePath]);
            }

            $testimonial->update([
                'type' => $validated['type'],
                'name' => $validated['name'],
                'image' => $imagePath ? str_replace('public/', 'storage/', $imagePath) : $testimonial->image,
                'address' => $validated['address'],
                'rating' => $validated['rating'],
                'review' => $validated['review'],
            ]);

            Log::info('Testimonial updated successfully', ['id' => $id]);

            return response()->json(['type' => 'success', 'message' => 'Testimonial updated successfully!'], 200);
        } catch (\Exception $e) {
            Log::error("Error updating testimonial ID: $id", ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while updating the testimonial. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $testiMonial = TestiMonial::findOrFail($id);
            $imagePath = $testiMonial->image;

            Log::info("Deleting testimonial ID: $id");

            $fullImagePath = public_path($imagePath);
            if (file_exists($fullImagePath)) {
                unlink($fullImagePath);
                Log::info('Image deleted', ['path' => $fullImagePath]);
            }

            $testiMonial->update(['is_delete' => 1, 'is_active' => 0]);

            Log::info('Testimonial marked as deleted', ['id' => $id]);

            return response()->json(['type' => 'success', 'message' => 'TestiMonial deleted successfully.']);
        } catch (\Exception $e) {
            Log::error("Error deleting testimonial ID: $id", ['error' => $e->getMessage()]);
            return response()->json(['type' => 'error', 'message' => 'Something Went Wrong.']);
        }
    }
}
