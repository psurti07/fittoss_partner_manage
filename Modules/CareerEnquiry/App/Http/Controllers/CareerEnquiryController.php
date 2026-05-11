<?php

namespace Modules\CareerEnquiry\App\Http\Controllers;

use App\Models\CareerEnquiry;
use App\DataTables\CareerEnquiryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CareerEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CareerEnquiryDataTable $dataTable)
    {
        return $dataTable->render('careerenquiry::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('careerenquiry::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('careerenquiry::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('careerenquiry::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Log::info('Destroy method called', ['id' => $id]);
        try{
            $careerEnquiry = CareerEnquiry::findOrFail($id);
            $careerEnquiry->update(['is_delete' => 1]);

            Log::info('Career deleted successfully', ['career' => $careerEnquiry]);

            return response()->json(['type' => 'success', 'message' => 'Career Enquiry deleted successfully!'], 200);
        } catch (\Exception $e) {

            Log::error('Error deleting Career Enquiry', ['error' => $e->getMessage()]);

            return response()->json(['type' => 'error', 'message' => 'An error occurred while deleting the Career Enquiry. Please try again.'], 500);
        }
    }
}
