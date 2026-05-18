<?php

namespace Modules\SupportRequest\App\Http\Controllers;

use App\DataTables\SupportRequestDataTable;
use App\Models\SupportRequest;
use App\Models\SupportRequestChat;
use App\Http\Controllers\Controller;
use App\Models\SmsList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\SiteOptions\App\Models\SiteOption;

class SupportRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SupportRequestDataTable $dataTable)
    {
        return $dataTable->render('supportrequest::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supportrequest::create');
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
        $supportRequest = SupportRequest::findOrFail($id);
        $remarks =  SupportRequestChat::with('staff')->where('requestid', $id)->where('is_delete', 0)->get();
        return view('supportrequest::modals.SupportRequest', compact('supportRequest', 'remarks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('supportrequest::edit');
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
        //
    }

    public function storeRemark(Request $request)
    {
        try {
            $inputs = $request->all();
            $request->validate([
                'remarks' => 'required'
            ]);
            $insData = [
                'rec_date' => date('Y-m-d H:i:s'),
                'requestid' => $inputs['requestid'],
                'remarks' => $inputs['remarks'],
                'staffid' => Auth::user()->id,
                'is_delete' => 0
            ];
            $res = SupportRequestChat::create($insData);
            $remarksData = SupportRequestChat::with('staff')->where('requestid', $inputs['requestid'])->where('is_delete', 0)->get();

            if ($res) {
                return response()->json(['type' => 'SUCCESS', 'data' => $remarksData, 'message' => 'Remarks added successfully'], 200);
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
            $reqData = SupportRequest::where('id', $inputs['supportId'])->first();
            if ($reqData->id > 0) {
                SupportRequest::where('id', $inputs['supportId'])->update(['status' => $inputs['status']]);
                $sms_slug = match ($inputs['status']) {
                    "2" => 'support-ticket-under-process',
                    "3" => 'support-ticket-closed',
                    "4" => 'support-ticket-contact',
                    "5" => 'support-ticket-not-contact',
                    default => '',
                };
                // 1=open,2=processing,3=closed,4=solved,5=Not in Contact;
                if ($sms_slug) {
                    $sender_id = SiteOption::where('option_key', 'common-senderid')->value('option_value');

                    // Fetch template safely
                    $message = SmsList::where('sms_slug', $sms_slug)
                        ->where('is_active', 1)
                        ->value('message');

                    // IMPORTANT: variable name must match DLT template
                    $message = str_replace('{#var#}', $reqData->ticketno, $message);
                    $smsResult = sendSingleSMS($reqData->mobile, $message, $sender_id);

                    Log::info('Raise Request SMS gateway response', [
                        'mobile' => $reqData->mobile,
                        'ticket' => $reqData->ticketno,
                        'response' => $smsResult
                    ]);
                }
                return response()->json(['type' => 'SUCCESS', 'data' => $inputs['status'], 'message' => 'Status changed successfully'], 200);
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong.'], 422);
        }
    }
}
