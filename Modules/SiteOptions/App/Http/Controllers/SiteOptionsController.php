<?php

namespace Modules\SiteOptions\App\Http\Controllers;

use App\Constants\OptionKeys;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Modules\Pages\App\Models\Page;
use Modules\SiteOptions\App\Models\SiteOption;

class SiteOptionsController extends Controller
{
    public function welcomeMessage()
    {
        $result = Page::where('slug', 'welcome-message')->first();
        $rec['data'] = $result;
        return view('siteoptions::layouts.welcomemessage')->with($rec);
    }

    public function welcomeMessageUpdate(Request $request)
    {
        try {
            $input = $request->all();
            $request->validate([
                'welcomemessage' => 'required',
                'status' => 'required|in:0,1',
            ]);
            $result = Page::where('slug', $input['name'])->update([
                'content' => $input['welcomemessage'],
                'status' => $input['status'],
            ]);

            $message = 'Welcome Message Successfully Updated';
            if ($result) {
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result), 200);
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Nothing to be change!'), 200);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['type' => 'ERROR', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong'], 200);
        }
    }

    /*  Axccount Message section  */
    public function accountMessage()
    {
        $sa = Page::where('slug', 'self-apply')->pluck('content')->first();
        $la = Page::where('slug', 'loan-agent')->pluck('content')->first();
        return view('siteoptions::layouts.accountmessage', compact('sa', 'la'));
    }

    public function accountMessageUpdate(Request $request)
    {
        try {
            $input = $request->all();
            Log::info($input);
            $slug = str_ireplace('-', '_', $input['slug']);

            $request->validate([
                'accountmessage_' . $slug => 'required'
            ], [
                'accountmessage_' . $slug . '.required' => 'This field is required'
            ]);

            $result = Page::where('slug', $input['slug'])->update(['content' => $input['accountmessage_' . $slug]]);

            $message = 'Important updates Message Successfully Updated';

            Log::info('Incoming request:', $request->all());

            if ($result) {
                return response()->json(['type' => 'SUCCESS', 'message' => $message, 'data' => $result], 200);
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'No changes detected or record not found!'], 200);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['type' => 'ERROR', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong'], 200);
        }
    }

    public function searchRecords($searchTerm)
    {
        return Page::select('content')->where('slug', 'LIKE', '%' . $searchTerm . '%')->first()->content;
    }

    public function smsSettings()
    {
        $options = SiteOption::whereIn('option_key', [
            OptionKeys::COMMON_SENDER_ID,
            OptionKeys::OFFER_PAGE_SENDER_ID,
            OptionKeys::OFFER_MARKETING_SENDER_ID
        ])->get();
        return view('siteoptions::smsSettings', compact('options'));
    }

    public function smsSettingsUpdate(Request $request)
    {
        try {
            $request->validate([
                'option_key'  => 'required|string',
                'option_value' => 'required|string|max:255',
            ], [
                'option_key.required' => 'Required field is missing or empty.',
                'option_value.required' => 'Required field is missing or empty.',
            ]);

            SiteOption::updateOrCreate(
                ['option_key' => $request->option_key],
                ['option_key' => $request->option_key, 'option_value' => $request->option_value]
            );

            return response()->json(['type' => 'SUCCESS', 'message' => 'SMS Settings updated successfully'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['type' => 'ERROR', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong'], 200);
        }
    }
}
