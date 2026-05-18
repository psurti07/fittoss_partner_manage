<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Partner\App\Models\CompanyStaff;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth::index');
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = CompanyStaff::where('email', $credentials['email'])
            ->where('is_delete', 0)
            ->first();

        if ($user && Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            DB::table('administrations_logs')->insert([
                'staff_id' => $user->id,
                'type' => 1
            ]);
            return response()->json([
                'type' => 'SUCCESS',
                'redirect' => route('manage.dashboard')
            ]);
        } else {
            return response()->json([
                'type' => 'ERROR',
                'message' => 'Invalid login credentials or account is deleted'
            ]);
        }
    }
}
