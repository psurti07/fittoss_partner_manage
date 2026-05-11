<?php

namespace Modules\BeforeAfterTestimonial\App\Http\Controllers;

use App\DataTables\BeforeAfterTestimonialDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\BeforeAfterTestimonial\App\Models\BeforeAfterTestiMonial;

class BeforeAfterTestimonialController extends Controller
{
    public function index(BeforeAfterTestimonialDataTable $datatable)
    {
        return $datatable->render('beforeaftertestimonial::index');
    }

    public function create()
    {
        return view('beforeaftertestimonial::modals.addBATestimonial');
    }

    public function store(Request $request)
    {
        Log::info('Store method called with request:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'before_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'after_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'service' => 'required|in:1,2',
            'days' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        try {
            $beforeimagePath = null;
            $afterimagePath = null;

            if ($request->hasFile('before_image')) {
                $image = $request->file('before_image');
                $imageName = time() . '-before-' . $image->getClientOriginalName();
                $destinationPath = public_path('assets/images/BeforeAfterTestiMonial');
                $image->move($destinationPath, $imageName);
                $beforeimagePath = 'assets/images/BeforeAfterTestiMonial/' . $imageName;
                Log::info('Before image uploaded.', ['path' => $beforeimagePath]);
            }

            if ($request->hasFile('after_image')) {
                $image = $request->file('after_image');
                $imageName = time() . '-after-' . $image->getClientOriginalName();
                $destinationPath = public_path('assets/images/BeforeAfterTestiMonial');
                $image->move($destinationPath, $imageName);
                $afterimagePath = 'assets/images/BeforeAfterTestiMonial/' . $imageName;
                Log::info('After image uploaded.', ['path' => $afterimagePath]);
            }

            $testimonial = BeforeAfterTestiMonial::create([
                'name' => $validated['name'],
                'before_image' => $beforeimagePath,
                'after_image' => $afterimagePath,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'service' => $validated['service'],
                'days' => $validated['days'],
                'rating' => $validated['rating'],
            ]);

            Log::info('Testimonial created successfully.', ['id' => $testimonial->id]);

            return response()->json(['type' => 'success', 'message' => 'Testimonial added successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Exception in store(): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['type' => 'error', 'message' => 'Something went wrong.'], 500);
        }
    }

    public function show($id)
    {
        return view('beforeaftertestimonial::show');
    }

    public function edit($id)
    {
        $data = BeforeAfterTestiMonial::findOrFail($id);
        return view('beforeaftertestimonial::modals.editBATestimonial', compact('data'));
    }

    public function update(Request $request, $id)
    {
        Log::info("Update method called for ID: $id", $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'before_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'after_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'service' => 'required|in:1,2',
            'days' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        try {
            $testimonial = BeforeAfterTestiMonial::findOrFail($id);

            $beforeimagePath = $testimonial->before_image;
            $afterimagePath = $testimonial->after_image;

            if ($request->hasFile('before_image')) {
                if ($beforeimagePath && file_exists(public_path($beforeimagePath))) {
                    unlink(public_path($beforeimagePath));
                    Log::info('Old before image deleted.', ['path' => $beforeimagePath]);
                }

                $image = $request->file('before_image');
                $imageName = time() . '-before-' . $image->getClientOriginalName();
                $destinationPath = public_path('assets/images/BeforeAfterTestiMonial');
                $image->move($destinationPath, $imageName);
                $beforeimagePath = 'assets/images/BeforeAfterTestiMonial/' . $imageName;
                Log::info('New before image uploaded.', ['path' => $beforeimagePath]);
            }

            if ($request->hasFile('after_image')) {
                if ($afterimagePath && file_exists(public_path($afterimagePath))) {
                    unlink(public_path($afterimagePath));
                    Log::info('Old after image deleted.', ['path' => $afterimagePath]);
                }

                $image = $request->file('after_image');
                $imageName = time() . '-after-' . $image->getClientOriginalName();
                $destinationPath = public_path('assets/images/BeforeAfterTestiMonial');
                $image->move($destinationPath, $imageName);
                $afterimagePath = 'assets/images/BeforeAfterTestiMonial/' . $imageName;
                Log::info('New after image uploaded.', ['path' => $afterimagePath]);
            }

            $testimonial->update([
                'name' => $validated['name'],
                'before_image' => $beforeimagePath,
                'after_image' => $afterimagePath,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'service' => $validated['service'],
                'days' => $validated['days'],
                'rating' => $validated['rating'],
            ]);

            Log::info('Testimonial updated.', ['id' => $id]);

            return response()->json(['type' => 'success', 'message' => 'Testimonial updated successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Exception in update(): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['type' => 'error', 'message' => 'Update failed.'], 500);
        }
    }

    public function destroy($id)
    {
        Log::info("Destroy method called for ID: $id");

        try {
            $testimonial = BeforeAfterTestiMonial::findOrFail($id);

            if ($testimonial->before_image && file_exists(public_path($testimonial->before_image))) {
                unlink(public_path($testimonial->before_image));
                Log::info('Deleted before image.', ['path' => $testimonial->before_image]);
            }

            if ($testimonial->after_image && file_exists(public_path($testimonial->after_image))) {
                unlink(public_path($testimonial->after_image));
                Log::info('Deleted after image.', ['path' => $testimonial->after_image]);
            }

            $testimonial->update(['is_delete' => 1, 'is_active' => 0]);
            Log::info('Testimonial marked as deleted.', ['id' => $id]);

            return response()->json(['type' => 'success', 'message' => 'Testimonial deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Exception in destroy(): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['type' => 'error', 'message' => 'Something went wrong.']);
        }
    }
}
