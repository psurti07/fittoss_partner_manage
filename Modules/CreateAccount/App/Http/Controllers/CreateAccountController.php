<?php

namespace Modules\CreateAccount\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use App\Models\Customer;
use App\Models\Product;
use App\Models\UserPersonalDetails;
use App\Services\BMIService;
use App\Services\InteraktService;
use App\Services\InvoiceService;
use App\Services\MailService;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateAccountController extends Controller
{
    public function getPostalDetails(Request $request)
    {
        try {
            $detail = getPostalDetailsByPincode($request->input('pincode'));
            return response()->json([
                'status'   => 'success',
                'district' => $detail['cityname'],
                'state'    => $detail['statename']
            ]);
        } catch (\Exception $e) {
            Log::error('Postal details error: ' . $e->getMessage());
            return response()->json([
                'status'   => 'false',
                'district' => '',
                'state'   => '',
                'message' => 'Invalid pincode or service error.'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::select(
            'productname',
            'productslug',
            'id',
            'amount',
            'offeramount',
            'inOffer'
        )
            ->where('is_active', 1)
            ->get();
        $diseases = Disease::where('is_delete', false)
            ->where('is_active', true)
            ->orderBy('id')
            ->get();
        return view('createaccount::create', compact('products', 'diseases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'product_id' => 'required|exists:products,id',
                'mobile_no' => 'required|numeric|digits:10|regex:/^[6-9]\d{9}$/',
                'email' => 'required|email',
                'amount' => 'required',
                'pincode' => 'required|digits:6',
                'state' => 'required',
                'city' => 'required',
                'created_at' => 'required',
                'paymentid' => 'required',
                'gender' => 'nullable',
                'age' => 'nullable',
                'height' => 'nullable',
                'weight' => 'nullable',
            ], [
                'amount.required' => 'The amount field is required.',
                'created_at.required' => 'The registration date field is required.',
            ]);
            $companyId = $request->company_id;
            $userDetail = Customer::where('mobile_no', $request->mobile_no)->where(['is_delete' => 0, 'is_active' => 1])->first();
            if (!empty($userDetail)) {
                return response()->json(['type' => 'ERROR', 'message' => 'User with mobile number is already registered'], 200);
            }

            $cgstamount = $sgstamount = $igstamount = 0;
            $paymentid = $request->paymentid;
            $amount = $request->amount;

            if (strtolower($request->state) == 'gujarat') {
                $cgstamount = $amount * 0.09;
                $sgstamount = $amount * 0.09;
            } else {
                $igstamount = $amount * 0.18;
            }
            $grand_total = $amount + $cgstamount + $sgstamount + $igstamount;

            if (($request->height ?? NULL) && ($request->weight ?? NULL)) {
                $BMIService = app(BMIService::class);
                $bmiData = $BMIService->calculateBMI($request->height, $request->weight);
                $bmi = $bmiData['bmi'] ?? 0;
            }

            /* DB transaction */
            DB::beginTransaction();
            $userReg = [
                'company_id' => $companyId,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'pincode' => $request->pincode,
                'city' => $request->city,
                'state' => $request->state,
                'process_step' => 5,
                'product_id' => $request->product_id,
                'order_id' => generateOrderId(Product::where('id', $request->product_id)->value('productslug')),
                'amount' => $amount,
                'grand_total' => $grand_total,
                'refcode' => generateRefCode($request->first_name),
                'created_at' => Carbon::parse($request->created_at),
                'is_user' => $request->is_user ?? 1,
                'is_agree' => $request->is_agree ?? 0
            ];
            $userDetail = Customer::create($userReg);
            $userId = $userDetail->id;

            $userPersonalDetail = [
                'userid' => $userId,
                'active_rate' => $request->active_rate ?? 0,
                'medical_issue' => !empty($request->medical_issue) ? json_encode($request->medical_issue) : NULL,
                'height' => $request->height ?? NULL,
                'weight' => $request->weight ?? NULL,
                'age' => $request->age ?? NULL,
                'bmi' => $bmi ?? NULL,
                'gender' => $request->gender ?? 1,
                'company_id' => $companyId,
            ];
            UserPersonalDetails::updateOrCreate(
                ['userid' => $userId],
                $userPersonalDetail
            );

            DB::commit();
            $paymentDetail = new \stdClass();
            $paymentDetail->payment_id = $paymentid;
            $paymentDetail->order_id = $userDetail->order_id;

            $invoiceService = app(InvoiceService::class);
            $invoice = $invoiceService->createInvoice($userDetail, $paymentDetail);
            app(SmsService::class)->sendPaymentSuccess($userDetail);
            app(MailService::class)->sendPaymentSuccessMail($userDetail, $invoice);
            $interaktService = app(InteraktService::class);
            $template_name = $interaktService->getInteraktSuccessTemplate($userDetail->product_id);
            $interaktService->sendMessage($userDetail, $template_name);

            return response()->json(['type' => 'SUCCESS', 'message' => 'Account created successfully.'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in CreateAccountController@store', [
                'errors' => $e->errors(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['type' => 'error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in CreateAccountController@store', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['type' => 'ERROR', 'message' => 'Something went wrong.'], 200);
        }
    }
}
