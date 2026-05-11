<?php

namespace Modules\SearchData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchDataController extends Controller
{
    public function index()
    {
        $products = Product::select(
            'product_title',
            'id',
        )
            ->where('is_active', 1)
            ->get();
        return view('searchdata::index', compact('products'));
    }

    public function searchData(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => ['required', 'exists:products,id'],
                'mobile_no' => ['required', 'regex:/^[6-9]\d{9}$/'],
            ], [
                "product_id.required" => "Please select product."
            ]);

            $userData = Customer::with('product:id,product_title')
                ->where('mobile_no', $validated['mobile_no'])
                ->where('product_id', $validated['product_id'])
                ->where('is_delete', 0)
                ->whereIn('is_user', [0, 1])
                ->first();

            if (!$userData) {
                return response()->json([
                    'type'    => 'ERROR',
                    'message' => 'User Not Found',
                    'data'    => '',
                ], 200);
            }

            $dataHtml = view('searchdata::data_list', compact('userData'))->render();

            return response()->json([
                'type' => 'SUCCESS',
                'data' => $userData->id,
                'html' => $dataHtml,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'type'   => 'ERROR',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('searchData', ['message' => $e->getMessage(), "trace" => $e->getTraceAsString()]);

            return response()->json([
                'type'    => 'ERROR',
                'message' => 'User Not Found',
                'data'    => '',
            ], 200);
        }
    }
}
