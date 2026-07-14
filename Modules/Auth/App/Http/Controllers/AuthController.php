<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WebsiteLinks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Partner\App\Models\Company;
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
            'password' => 'required',
            'company_code' => 'required|exists:companies,company_code'
        ]);

        $companyId = Company::where('company_code', $request->company_code)->value('id');
        $user = CompanyStaff::where('email', $credentials['email'])
            ->where('company_id', $companyId)
            ->where('is_delete', 0)
            ->first();

        if ($user && Auth::attempt(['company_id' => $companyId, 'email' => $credentials['email'], 'password' => $credentials['password']])) {
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

    public function test()
    {
        $products = Product::select('productslug', 'productname')->get();
        $links = [];
        $companies = Company::whereIn('id', [2, 3, 4, 5])->select('id', 'company_code')->get();
        foreach ($companies as $company) {
            foreach ($products as $product) {
                $links[] = [
                    'rec_date' => now(),
                    'company_id' => $company->id,
                    'title' => $product->productname,
                    'link' => "https://fittoss.com/partner/" . $company->company_code . "/" . $product->productslug,
                    'isActive' => 1,
                    'isDelete' => 0,
                ];
            }
        }
        WebsiteLinks::insert($links);
    }
}
