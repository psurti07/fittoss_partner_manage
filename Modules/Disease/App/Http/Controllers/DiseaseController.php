<?php

namespace Modules\Disease\App\Http\Controllers;

use App\Models\Disease;
use App\DataTables\DiseaseDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DiseaseDataTable $datatable)
    {
        return $datatable->render('disease::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('disease::modals.addDisease');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store method called', ['request' => $request->all()]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $disease = Disease::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'rec_date' => now(),
                'is_delete' => false,
                'is_active' => true,
            ]);

            Log::info('Disease created successfully', ['disease' => $disease]);

            return response()->json(['type' => 'success', 'message' => 'Disease added successfully!'], 200);
        } catch (\Exception $e) {

            Log::error('Error storing disease', ['error' => $e->getMessage()]);

            return response()->json(['type' => 'error', 'message' => 'Failed to add disease!'], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('disease::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Disease::findOrFail($id);

        return view('disease::modals.editDisease', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Log::info('Update method called', ['request' => $request->all()]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $disease = Disease::findOrFail($id);

            $disease->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'rec_date' => now(),
                'is_delete' => false,
                'is_active' => true,
            ]);

            Log::info('Disease updated successfully', ['disease' => $disease]);

            return response()->json(['type' => 'success', 'message' => 'Disease updated successfully!'], 200);
        } catch (\Exception $e) {

            Log::error('Error updating disease', ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', 'An error occurred while updating the disease. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Log::info('Destroy method called', ['id' => $id]);
        try{
            $disease = Disease::findOrFail($id);
            $disease->update(['is_delete' => 1, 'is_active' => 0]);

            Log::info('Disease deleted successfully', ['disease' => $disease]);

            return response()->json(['type' => 'success', 'message' => 'Disease deleted successfully!'], 200);
        } catch (\Exception $e) {

            Log::error('Error deleting disease', ['error' => $e->getMessage()]);

            return response()->json(['type' => 'error', 'message' => 'An error occurred while deleting the disease. Please try again.'], 500);
        }
    }
}
