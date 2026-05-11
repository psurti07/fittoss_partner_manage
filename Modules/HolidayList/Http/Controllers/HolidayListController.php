<?php

namespace Modules\HolidayList\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\HolidayList;
use App\DataTables\HolidayListDataTable;
use Illuminate\Support\Facades\Log;

class HolidayListController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(HolidayListDataTable $datatable)
    {
        return $datatable->render('holidaylist::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('holidaylist::modals.addHolidayList');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'holiday_date' => 'required|date',
            'holiday_name' => 'required|string|max:255',
            'holiday_type' => 'required|string|max:50',
        ]);

        try {
            HolidayList::create([
                'rec_date' => now(),
                'holiday_date' => $validated['holiday_date'],
                'holiday_name' => $validated['holiday_name'],
                'holiday_type' => $validated['holiday_type'],
                'isDelete' => 0,
            ]);

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Holiday created successfully!'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Holiday Store Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'type' => 'ERROR',
                'message' => 'Something went wrong while creating the holiday.'
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
        return view('holidaylist::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $holiday = HolidayList::findOrFail($id);
        return view('holidaylist::modals.editHolidayList', compact('holiday'));
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
            'holiday_date' => 'required|date',
            'holiday_name' => 'required|string|max:255',
            'holiday_type' => 'required|string|max:50',
        ]);

        try {
            $holiday = HolidayList::findOrFail($id);
            $holiday->update([
                'holiday_date' => $validated['holiday_date'],
                'holiday_name' => $validated['holiday_name'],
                'holiday_type' => $validated['holiday_type'],
            ]);

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Holiday updated successfully!'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Holiday Update Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'type' => 'ERROR',
                'message' => 'Something went wrong while updating the holiday.'
            ], 500);
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
            $holiday = HolidayList::findOrFail($id);
            $holiday->update(['isDelete' => 1]);
            return response()->json(['type' => 'SUCCESS', 'message' => 'Holiday deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['type' => 'ERROR', 'message' => 'Something Went Wrong.']);
        }
    }
}
