<?php

namespace Modules\SiteOptions\App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UATNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $companyId = $request->company_id;
        $numbers = DB::table('uat_numbers')
            ->select(
                'id',
                'payment_numbers',
                'remarketing_numbers',
                'updated_at'
            )
            ->where('company_id', $companyId)
            ->first();

        return view('siteoptions::uat-number.index', compact('numbers'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'payment_numbers' => 'nullable',
            'remarketing_numbers' => 'nullable',
        ]);
        try {
            $paymentNumbers = preg_replace('/\s+/', '', $request->payment_numbers ?? '');
            $remarketingNumbers = preg_replace('/\s+/', '', $request->remarketing_numbers ?? '');

            DB::table('uat_numbers')->updateOrInsert(
                [
                    'company_id' => $request->company_id,
                ],
                [
                    'payment_numbers' => $paymentNumbers ?: null,
                    'remarketing_numbers' => $remarketingNumbers ?: null,
                    'updated_at' => now(),
                ]
            );

            return response()->json(array('type' => 'SUCCESS', 'message' => 'UAT Numbers updated successfully'));
        } catch (\Exception $e) {
            Log::error('update', ['error' => $e->getMessage(), 'TraceAsString' => $e->getTraceAsString()]);
            return response()->json(array('type' => 'ERROR', 'message' => 'Something went wrong while updating partner'));
        }
    }

}
