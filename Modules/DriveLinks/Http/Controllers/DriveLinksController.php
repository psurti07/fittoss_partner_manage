<?php

namespace Modules\DriveLinks\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\DriveLinks;
use Illuminate\Support\Facades\Log;

class DriveLinksController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $drivelinks = DriveLinks::where('isDelete', 0)
            ->when(app('company_id') != 1, function ($query) {
                $query->where('link_type', 2);
            })
            ->orderBy('department')
            ->orderByDesc('rec_date')
            ->get()
            ->groupBy('department');

        return view('drivelinks::index', compact('drivelinks'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('drivelinks::modals.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url|max:255',
            'department' => 'required',
        ]);

        try {
            $driveLink = DriveLinks::create([
                'rec_date' => now(),
                'title' => $validated['title'],
                'link' => $validated['link'],
                'department' => $validated['department'],
                'isActive' => 1,
                'isDelete' => 0,
            ]);

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Drive Links created successfully!',
                'data' => $driveLink
            ], 200);
        } catch (\Exception $e) {
            Log::error('Drive Links Store Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'type' => 'ERROR',
                'message' => 'Something went wrong while creating the Drive Links.'
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('drivelinks::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $drivelinks = DriveLinks::findOrFail($id);
        return view('drivelinks::modals.edit', compact('drivelinks'));
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
            'title' => 'required|string|max:255',
            'link' => 'required|url|max:255',
            'department' => 'required',
        ]);

        try {
            $drivelinks = DriveLinks::findOrFail($id);

            $dataToUpdate = [
                'rec_date' => now(),
                'title' => $validated['title'],
                'link' => $validated['link'],
                'department' => $validated['department'],
                'isActive' => 1,
                'isDelete' => 0,
            ];

            $drivelinks->update($dataToUpdate);

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Drive links updated successfully!',
                'data' => $drivelinks
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong.'], 500);
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
            $drivelinks = DriveLinks::findOrFail($id);
            $drivelinks->update(['isDelete' => 1, 'isActive' => 0]);
            return response()->json(['type' => 'SUCCESS', 'message' => 'Drive Links deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['type' => 'ERROR', 'message' => 'Something Went Wrong.']);
        }
    }

    public function changeStatus($id)
    {
        try {
            $drivelinks = DriveLinks::findOrFail($id);
            $drivelinks->isActive = !$drivelinks->isActive;
            $drivelinks->save();

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Drive Links status updated successfully',
                'status' => $drivelinks->isActive
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => 'Failed to update status'
            ], 500);
        }
    }
}
