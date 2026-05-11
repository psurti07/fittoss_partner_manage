<?php

namespace Modules\Career\App\Http\Controllers;

use App\Models\Career;
use App\DataTables\CareerDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CareerDataTable $datatable)
    {
        return $datatable->render('career::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('career::modals.addCareer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store method called', ['request' => $request->all()]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Log::info('Validated data', ['validated' => $validated]);

        try {
            $career = Career::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'slug' => Str::random(3) . rand(100, 999),
                'rec_date' => now(),
                'is_delete' => false,
                'is_active' => true,
            ]);

            Log::info('Career created successfully', ['career' => $career]);

            return response()->json(['type' => 'success', 'message' => 'Career added successfully!'], 200);
        } catch (\Exception $e) {

            Log::error('Error storing career', ['error' => $e->getMessage()]);

            return response()->json(['type' => 'error', 'message' => 'Failed to add career!'], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('career::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Career::findOrFail($id);

        return view('career::modals.editCareer', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Log::info('Update method called', ['request' => $request->all()]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {

            $career = Career::findOrFail($id);

            $career->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'slug' => Str::random(3) . rand(100, 999),
                'rec_date' => now(),
                'is_delete' => false,
                'is_active' => true,
            ]);

            Log::info('Career updated successfully', ['career' => $career]);

            return response()->json(['type' => 'success', 'message' => 'Career updated successfully!'], 200);
        } catch (\Exception $e) {

            Log::error('Error updating career', ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', 'An error occurred while updating the career. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Log::info('Destroy method called', ['id' => $id]);
        try{
            $career = Career::findOrFail($id);
            $career->update(['is_delete' => 1, 'is_active' => 0]);

            Log::info('Career deleted successfully', ['career' => $career]);

            return response()->json(['type' => 'success', 'message' => 'Career deleted successfully!'], 200);
        } catch (\Exception $e) {

            Log::error('Error deleting Career', ['error' => $e->getMessage()]);

            return response()->json(['type' => 'error', 'message' => 'An error occurred while deleting the career. Please try again.'], 500);
        }
    }

    public function changeStatus(Request $request)
    {
        $career = Career::find($request->id);

        if ($career) {
            $career->is_active = $request->is_active;
            $career->save();

            return response()->json([
                'success' => true,
                'message' => "Status changed successfully!"
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Career not found!'
        ]);
    }

}
