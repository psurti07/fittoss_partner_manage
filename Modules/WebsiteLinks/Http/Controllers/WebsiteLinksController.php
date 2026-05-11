<?php

namespace Modules\WebsiteLinks\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\WebsiteLinks;
use App\DataTables\WebsiteLinksDataTable;
use Illuminate\Support\Facades\Log;

class WebsiteLinksController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(WebsiteLinksDataTable $dataTable)
    {
        return $dataTable->render('websitelinks::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('websitelinks::modals.create');
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
            'short_link' => 'nullable'
        ]);

        try {
            $websiteLink = WebsiteLinks::create([
                'rec_date' => now(),
                'title' => $validated['title'],
                'link' => $validated['link'],
                'short_link' => $validated['short_link'],
                'isActive' => 1,
                'isDelete' => 0,
            ]);

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Website Links created successfully!',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Website Links Store Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'type' => 'ERROR',
                'message' => 'Something went wrong while creating the Website Links.'
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
        return view('websitelinks::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $websitelinks = WebsiteLinks::findOrFail($id);
        return view('websitelinks::modals.edit', compact('websitelinks'));
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
            'short_link' => 'nullable'
        ]);

        try {
            $websiteLink = WebsiteLinks::findOrFail($id);

            $dataToUpdate = [
                'rec_date' => now(),
                'title' => $validated['title'],
                'link' => $validated['link'],
                'short_link' => $validated['short_link'],
                'isActive' => 1,
                'isDelete' => 0,
            ];
            
            $websiteLink->update($dataToUpdate);

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Website links updated successfully!',
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
            $websiteLink = WebsiteLinks::findOrFail($id);
            $websiteLink->update(['isDelete' => 1, 'isActive' => 0]);
            return response()->json(['type' => 'SUCCESS', 'message' => 'Website Links deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['type' => 'ERROR', 'message' => 'Something Went Wrong.']);
        }
    }
    
    public function changeStatus($id)
    {
        try {
            $websiteLink = WebsiteLinks::findOrFail($id);
            $websiteLink->isActive = !$websiteLink->isActive;
            $websiteLink->save();

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Website Links status updated successfully',
                'status' => $websiteLink->isActive
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => 'Failed to update status'
            ], 500);
        }
    }
}
