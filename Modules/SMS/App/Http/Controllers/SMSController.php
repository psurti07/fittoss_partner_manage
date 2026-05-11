<?php

namespace Modules\SMS\App\Http\Controllers;

use App\DataTables\SmsMessageDataTable;
use App\DataTables\SmsTemplateDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\SmsList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class SMSController extends Controller
{
    public function smsMessage(SmsMessageDataTable $dataTable)
    {
        return $dataTable->render('sms::messages');
    }

    public function editSmsMessage($id)
    {
        $sms = SmsList::findOrFail($id);
        return view('sms::modals.editSMS', [
            'data' => $sms,
        ]);
    }

    public function updateSmsMessage(Request $request, $id)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $sms = SmsList::findOrFail($id);

            $sms->update([
                'message' => $validated['message'],
                'rec_date' => now(),
            ]);

            //Log::info('SMS updated successfully', ['sms' => $sms]);

            return response()->json(['type' => 'SUCCESS', 'message' => 'SMS updated successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating SMS', ['error' => $e->getMessage()]);

            return response()->json(['type' => 'error', 'message' => 'An error occurred while updating the SMS. Please try again.'], 500);
        }
    }

    public function testSms()
    {
        $titles = DB::table('sms_list')->where('is_active', 1)->get();
        return view('sms::modals.testSms', compact('titles'));
    }

    public function getMessage(Request $request)
    {
        try {
            $res = DB::table('sms_list')->where('id', $request->title)->first()->message;
            return response()->json(['type' => 'SUCCESS', 'message' => $res]);
        } catch (\Exception $e) {
            Log::info('getting error from getMessage - ' . $e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Oops!Something went wrong.']);
        }
    }

    public function fireSms(Request $request)
    {
        try {
            $request->validate([
                'mobile' => ['required', 'numeric', 'regex:/^[6-9]\d{9}$/'],
                'title' => 'required',
                'message' => 'required'
            ]);
            $res = sendSingleSMS($request->mobile, $request->message, $request->senderid);
            //Log::info('getting error from getMessage - ' , [$res]);

            if ($res['status_code'] == 200) {
                return response()->json(['type' => 'SUCCESS', 'message' => 'Message sent successfully.']);
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'Message sending failed.']);
            }
        } catch (\Exception $e) {
            Log::info('fire sms function - ' . $e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Oops!Something went wrong.']);
        }
    }

    public function sendCustomSms()
    {
        return view('sms::sendcustom');
    }

    public function toggleStatus($id)
    {
        try {
            $smslist = SmsList::findOrFail($id);
            $smslist->is_active = !$smslist->is_active;
            $smslist->save();

            return response()->json([
                'type' => 'SUCCESS',
                'message' => 'Sms Template status updated successfully',
                'status' => $smslist->is_active
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => 'Failed to update status'
            ], 500);
        }
    }
}
