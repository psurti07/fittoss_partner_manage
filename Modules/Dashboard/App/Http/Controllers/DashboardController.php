<?php

namespace Modules\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OtpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Customer::whereDate('updated_at', now())
            ->whereIn('product_id', [
                config('constant.WEIGHT_LOSS_PROGRAM_ID'),
                config('constant.WEIGHT_LOSS_WEBINAR_ID'),
                config('constant.BODYFAT_ANALYSIS_WORKSHOP_ID')
            ])
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->selectRaw("product_id,
                         SUM(CASE WHEN is_user = 0 THEN 1 ELSE 0 END) as leads,
                         SUM(CASE WHEN is_user = 1 THEN 1 ELSE 0 END) as customers,
                         SUM(CASE WHEN is_user = 1 THEN grand_total ELSE 0 END) as amount")
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        $otps = OtpVerification::whereDate('updated_at', now())
            ->whereIn('product_id', [
                config('constant.WEIGHT_LOSS_PROGRAM_ID'),
                config('constant.WEIGHT_LOSS_WEBINAR_ID'),
                config('constant.BODYFAT_ANALYSIS_WORKSHOP_ID')
            ])
            ->selectRaw("product_id,count(id) as total")
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        return view('dashboard::index', compact('data', 'otps'));
    }

    public function logout()
    {
        $user = auth()->user();
        DB::table('administrations_logs')->insert([
            'staff_id' => $user->id,
            'type' => 2
        ]);
        Session::flush();
        Auth::logout();

        return redirect('/');
    }

    public function changePassword()
    {
        return view('dashboard::layouts.change-password');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['type' => 'ERROR', 'message' => 'Old password is incorrect', 'data' => []]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['type' => 'SUCCESS', 'message' => 'Password updated successfully', 'data' => []]);
    }
}
