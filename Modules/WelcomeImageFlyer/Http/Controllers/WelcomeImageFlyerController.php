<?php

namespace Modules\WelcomeImageFlyer\Http\Controllers;

use App\DataTables\WelcomeImageFlyerDataTable;
use App\Models\WelcomeImageFlyer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WelcomeImageFlyerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(WelcomeImageFlyerDataTable $dataTable)
    {
        return $dataTable->render('welcomeimageflyer::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('welcomeimageflyer::modals.addFlyer');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'flyer_img' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'flyer_name' => 'required|string|max:255',
        ]);

        try {
            // $imageName = null;
            if ($request->hasFile('flyer_img')) {
                $image = $request->file('flyer_img');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('assets/images/flyer');
                if (!file_exists($path)) {
                    mkdir($path, 0775, true);
                }
                $image->move($path, $imageName);
            }

            $flyer = WelcomeImageFlyer::create([
                'flyer_name' => $validated['flyer_name'],
                'flyer_img' => $imageName,
                'is_active' => true,
                'is_delete' => false,
            ]);


            return response()->json(['type' => 'SUCCESS', 'message' => 'Flyer added successfully'], 200);
        } catch (\Exception $e) {


            return response()->json(['type' => 'error', 'message' => 'Failed to add flyer!'], 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('welcomeimageflyer::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $result = WelcomeImageFlyer::where('id', $id)->first();
        return view('welcomeimageflyer::modals.editFlyer', [
            'data' => $result,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'flyer_img' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'flyer_name' => 'required|string|max:255',
        ]);

        try {
            $flyer = WelcomeImageFlyer::findOrFail($id);

            $imageName = $flyer->flyer_img;

            if ($request->hasFile('flyer_img')) {
                if (!empty($flyer->flyer_img)) {
                    $oldImagePath = public_path('assets/images/flyer/' . $flyer->flyer_img);
                    if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image = $request->file('flyer_img');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('assets/images/flyer');
                if (!file_exists($path)) {
                    mkdir($path, 0775, true);
                }
                $image->move($path, $imageName);
            }

            $flyer->update([
                'flyer_name' => $validated['flyer_name'],
                'flyer_img' => $imageName,
                'is_active' => true,
                'is_delete' => false,
            ]);


            return response()->json(['type' => 'SUCCESS', 'message' => 'Flyer updated successfully'], 200);
        } catch (\Exception $e) {

            return response()->json(['type' => 'error', 'message' => 'An error occurred while updating the Flyer. Please try again.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $flyer = WelcomeImageFlyer::findOrFail($id);
            $flyer->update(['is_delete' => 1, 'is_active' => 0]);


            return response()->json(['type' => 'SUCCESS', 'message' => 'Flyer deleted successfully'], 200);
        } catch (\Exception $e) {

            return response()->json(['type' => 'error', 'message' => 'An error occurred while deleting the Flyer. Please try again.'], 500);
        }
    }
    public function toggleStatus($id)
    {
        try {
            $flyer = WelcomeImageFlyer::findOrFail($id);
            $newStatus = !$flyer->is_active;
            $flyer->update(['is_active' => $newStatus]);


            return response()->json(['type' => 'SUCCESS', 'message' => 'Flyer status updated successfully'], 200);
        } catch (\Exception $e) {

            return response()->json(['type' => 'error', 'message' => 'An error occurred while updating the Flyer status. Please try again.'], 500);
        }
    }

}
