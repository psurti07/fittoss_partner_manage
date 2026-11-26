<?php

namespace Modules\Contact\App\Http\Controllers;

use App\DataTables\ContactInquiryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Contact\App\Models\ContactInquiry;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ContactInquiryDataTable $datatable)
    {
        return $datatable->render('contact::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contact::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $supportRequest = ContactInquiry::findOrFail($id);
        return view('contact::modals.ContactRequest', compact('supportRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('contact::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function storeRemark(Request $request)
    {
        try {
            $inputs = $request->all();
            $request->validate([
                'remarks' => 'required'
            ]);
            $res = ContactInquiry::where('id', $inputs['requestid'])->update(['remarks' => $inputs['remarks']]);
            if ($res) {
                return response()->json(['type' => 'SUCCESS', 'data' => [], 'message' => 'Remarks added successfully'], 200);
            } else {
                return response()->json(['type' => 'SUCCESS', 'message' => 'Server is busy right now. Try after some time'], 200);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['type' => 'error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong'], 422);
        }
    }

    public function changeSupportStatus(Request $request)
    {
        try {
            $inputs = $request->all();
            $reqData = ContactInquiry::where('id', $inputs['requestId'])->first();
            if ($reqData->id > 0) {
                ContactInquiry::where('id', $inputs['requestId'])->update(['status' => $inputs['status']]);
                return response()->json(['type' => 'SUCCESS', 'data' => $inputs['status'], 'message' => 'Status changed successfully'], 200);
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong.'], 422);
        }
    }
}
