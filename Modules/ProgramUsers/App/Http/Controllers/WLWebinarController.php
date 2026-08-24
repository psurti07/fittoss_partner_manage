<?php

namespace Modules\ProgramUsers\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\OtpVerification;
use App\Models\Product;
use App\Models\UserPersonalDetails;
use App\Services\BMIService;
use App\Services\InteraktService;
use App\Services\InvoiceService;
use App\Services\MailService;
use App\Services\SmsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class WLWebinarController extends Controller
{
    public function customers(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                0 => 'id',
                1 => 'updated_at',
                2 => 'first_name',
                3 => 'mobile_no',
                4 => 'email',
                5 => 'city',
                6 => 'state',
                7 => 'pincode',
            ];

            $search = $request->input('search')['value'] ?? NULL;
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $query = Customer::select(
                'id',
                'first_name',
                'last_name',
                'email',
                'mobile_no',
                'product_id',
                'city',
                'pincode',
                'state',
                'is_attend',
                'updated_at'
            )
                ->where('is_active', 1)
                ->where('is_user', 1)
                ->where('is_delete', 0)
                ->where('product_id', config('constant.WEIGHT_LOSS_WEBINAR_ID'));
            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereRaw('DATE(updated_at)  BETWEEN  ? AND ?', [$fromDate, $toDate]);
            }
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('mobile_no', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('state', 'like', "%{$search}%");
                });
            }
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('updated_at', 'desc');
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at)) . '<br>' . date('h:i:s A', strtotime($row->updated_at));
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('attend', function ($row) {
                    if ($row->is_attend) {
                        return '<button type="button"
                                class="btn btn-sm btn-success attendBtn"
                                onclick="attended(' . $row->id . ',0)">
                                Attended
                            </button>';
                    }
                    return '<button type="button"
                                class="btn btn-sm btn-info attendBtn"
                                onclick="attended(' . $row->id . ',1)">
                                Not Attend
                            </button>';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="" href="' . route('manage.weight-loss-webinar.customers.details', ['userId' => $row->id]) . '"><i class="fa fa-info-circle"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'attend', 'action'])
                ->make(true);
        }
        return view('programusers::weight-loss-webinar.customers');
    }

    public function usersDetails($userId)
    {
        $customer = Customer::with('personalDetails')->where(['id' => $userId, 'is_delete' => 0, 'is_user' => 1])->first();
        $invoices = Invoice::where('userid', $userId)->get();
        $diseases = Disease::where('is_delete', false)->where('is_active', true)->orderBy('id')->get();
        $referralUsers = [];

        if ($customer != null) {
            return view('programusers::weight-loss-webinar.customerDetails', compact(['customer', 'invoices', 'referralUsers', 'diseases']));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Users not found!', 'data' => ''));
        }
    }

    public function usersDetailsUpdate(Request $request)
    {
        $userId = $request->input('userid');
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            // 'email' => 'required|email|unique:customers,email,' . $userId . ',id,product_id,' . config('constant.WEIGHT_LOSS_WEBINAR_ID'),
            'email' => 'required|email',
            'pincode' => 'required|digits:6',
            'state' => 'required',
            'city' => 'required',
        ]);

        $result = Customer::where('id', $userId)->update(array(
            'first_name' => trim(ucfirst($request->input('first_name'))),
            'last_name' => trim(ucfirst($request->input('last_name'))),
            'email' => trim(strtolower($request->input('email'))),
            'pincode' => $request->input('pincode'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
        ));

        if (($request->height ?? NULL) && ($request->weight ?? NULL)) {
            $BMIService = app(BMIService::class);
            $bmiData = $BMIService->calculateBMI($request->height, $request->weight);
            $bmi = $bmiData['bmi'] ?? 0;
        }
        $userPersonalDetail = [
            'userid' => $userId,
            'active_rate' => $request->active_rate ?? 0,
            'medical_issue' => !empty($request->medical_issue) ? json_encode($request->medical_issue) : NULL,
            'height' => $request->height ?? NULL,
            'weight' => $request->weight ?? NULL,
            'age' => $request->age ?? NULL,
            'bmi' => $bmi ?? NULL,
            'gender' => $request->gender ?? 1,
        ];
        UserPersonalDetails::updateOrCreate(
            ['userid' => $userId],
            $userPersonalDetail
        );
        if ($result > 0) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Data updated successfully', 'data' => ''));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Data already updated!', 'data' => ''));
        }
    }

    public function markAsAttended(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'status' => 'required'
        ]);
        $res = Customer::where('id', $request->user_id)->update(['is_attend' => $request->status]);
        if ($res) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'User\'s attend status change successfully!', 'data' => ''));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => ''));
        }
    }

    public function downloadPdf($id)
    {
        $invoice = Invoice::with('user')
            ->where('id', $id)
            ->firstOrFail();
        $invoiceData = [
            'invoice' => $invoice,
            'user' => $invoice->user
        ];

        $pdf = Pdf::loadView('invoice.invoice_pdf', $invoiceData);
        return $pdf->download('invoice-' . $invoice->order_id . '.pdf');
    }

    public function downloadBMIReport($userId)
    {
        $userData = Customer::with(['personalDetails'])->where('id', $userId)->first();
        $personalDetails = $userData->personalDetails;
        $bmi = $personalDetails->bmi ?? NULL;
        if (!$bmi && ($personalDetails->height ?? NULL) && ($personalDetails->weight ?? NULL) && ($personalDetails->gender ?? NULL) && ($personalDetails->age ?? NULL)) {
            $BMIService = app(BMIService::class);
            $bmiData = $BMIService->calculateBMI($personalDetails->height, $personalDetails->weight, $personalDetails->gender, $personalDetails->age);
            $bmi = $bmiData['bmi'] ?? 0;
            UserPersonalDetails::where('userid', $userId)->update(['bmi' => $bmi]);
        }
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $userData->first_name . '_' . $userData->last_name);
        $product = Product::find(config('constant.WEIGHT_LOSS_WEBINAR_OFFER_ID'));
        $url = "https://fittoss.com/weight-loss-webinar-offer";
        return view('programusers::bmi_detail', compact('userData', 'personalDetails', 'product', 'url'));
        $pdf = Pdf::loadView('programusers::bmi_report_pdf', compact('userData', 'personalDetails', 'product'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('bmi_report_' . $safeName . '.pdf');
    }

    public function updatePassword(Request $request)
    {
        $user = Customer::find($request->input('userid'));
        if ($user != null) {
            $request->validate([
                'new_password' => 'required',
                'retype_password' => 'required|same:new_password'
            ]);
            $result = $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
            if ($result) {
                sendChangePasswordEmail($user->first_name . ' ' . $user->last_name, $user->email, $user->mobile_no, $request->input('new_password'));
                return response()->json(array('type' => 'SUCCESS', 'message' => 'Password updated successfully', 'data' => []));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
            }
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'User not found!', 'data' => []));
        }
    }

    public function deactivateAccount(Request $request)
    {
        $user = Customer::find($request->input('userid'));
        if ($user) {
            $updateData = array('is_active' => $request->input('status'));
            $result = Customer::where('id', $request->input('userid'))->update($updateData);
            $message = '';
            if ($request->input('status') == 1) {
                $message = 'Account activated successfully';
            } else {
                $message = 'Account deactivate successfully';
            }
            if ($result > 0) {
                return response()->json(['type' => 'SUCCESS', 'message' => $message]);
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'Oops! Something went wrong.']);
            }
        } else {
            return response()->json(['type' => 'ERROR', 'message' => 'Invalid user perform action!']);
        }
    }

    public function deleteAccount(Request $request)
    {
        try {
            $userId = $request->input('userid');
            DB::transaction(function () use ($userId) {
                Invoice::where('userid', $userId)->update(['is_delete' => 1]);
                Customer::where('id', $userId)->update(['is_delete' => 1]);
            });
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Customer remove successfully!'));
        } catch (\Exception $e) {
            Log::error('error', ['error' => $e->getMessage()]);
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.'));
        }
    }


    // Leads
    public function statistics()
    {
        $data = Customer::whereDate('updated_at', now())
            ->where('product_id', config('constant.WEIGHT_LOSS_WEBINAR_ID'))
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->selectRaw("SUM(CASE WHEN is_user = 0 THEN 1 ELSE 0 END) as leads,
                         SUM(CASE WHEN is_user = 1 THEN 1 ELSE 0 END) as customers,
                         SUM(CASE WHEN is_user = 1 THEN grand_total ELSE 0 END) as amount")
            ->first();

        $otps = OtpVerification::where('product_id', config('constant.WEIGHT_LOSS_WEBINAR_ID'))
            ->whereDate('updated_at', now())
            ->count();

        $leads = $data->leads ?? 0;
        $customers = $data->customers ?? 0;
        $amount = $data->amount ?? 0;
        return view('programusers::weight-loss-webinar.statistics', compact('leads', 'customers', 'amount', 'otps'));
    }

    public function leads(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                0 => 'id',
                1 => 'updated_at',
                2 => 'first_name',
                3 => 'mobile_no',
                4 => 'email',
                5 => 'city',
                6 => 'state',
                7 => 'pincode',
            ];
            $search = $request->input('search')['value'] ?? NULL;
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $query = Customer::with('personalDetails')
                ->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'mobile_no',
                    'product_id',
                    'city',
                    'pincode',
                    'state',
                    'updated_at'
                )
                ->where('is_active', 1)
                ->where('is_user', 0)
                ->where('is_delete', 0)
                ->where('product_id', config('constant.WEIGHT_LOSS_WEBINAR_ID'));
            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereRaw('DATE(updated_at)  BETWEEN  ? AND ?', [$fromDate, $toDate]);
            }
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('mobile_no', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('state', 'like', "%{$search}%");
                });
            }
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('updated_at', 'desc');
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at)) . '<br>' . date('h:i:s A', strtotime($row->updated_at));
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                // Export columns
                ->addColumn('height', function ($row) {
                    return optional($row->personalDetails)->height;
                })
                ->addColumn('weight', function ($row) {
                    return optional($row->personalDetails)->weight;
                })
                ->addColumn('bmi', function ($row) {
                    return optional($row->personalDetails)->bmi;
                })
                ->addColumn('age', function ($row) {
                    return optional($row->personalDetails)->age;
                })
                ->addColumn('gender', function ($row) {
                    return  match (optional($row->personalDetails)->gender) {
                        1 => 'Male',
                        2 => 'Female',
                        default => 'Other'
                    };
                })
                ->addColumn('medical_issue', function ($row) {
                    return optional($row->personalDetails)->medical_issue;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<ul class="action" style="display:block">
                                    <li class="info" style="display: flex;align-items: center;justify-content: center;"> <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')"><i class="fa fa-info-circle"></i></a></li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('programusers::weight-loss-webinar.leads');
    }

    public function info(Request $request)
    {
        $userDetails = Customer::with('personalDetails')->where('id', $request->input('infoId'))->first();
        $userOtps = OtpVerification::select('mobile', 'otp_code', 'rec_date')->where('mobile', $userDetails->mobile_no)->orderByDesc('id')->get();
        $rec['details'] = $userDetails;
        $rec['otps'] = $userOtps;
        return view('programusers::weight-loss-webinar.infodetails')->with($rec);
    }

    public function blockUser(Request $request)
    {
        $exists = Customer::find($request->id);
        if ($exists) {
            if ($exists->is_active === 1) {
                $block = Customer::where('id', $request->id)->update(['is_active' => 0]);
                if ($block) {
                    return response()->json(array('type' => 'SUCCESS', 'message' => 'User has been blocked successfully!', 'data' => ''));
                } else {
                    return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong while blocking user.', 'data' => ''));
                }
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'User is already blocked!', 'data' => ''));
            }
        }
        return response()->json(array('type' => 'ERROR', 'message' => 'Invalid action perform.', 'data' => ''));
    }

    public function dndUser(Request $request)
    {
        $exists = Customer::find($request->id);
        if ($exists) {
            if ($exists->is_dnd === 0) {
                $dnd = Customer::where('id', $request->id)->update(['is_dnd' => 1]);
                if ($dnd) {
                    return response()->json(array('type' => 'SUCCESS', 'message' => 'User has been set to DND.', 'data' => ''));
                } else {
                    return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong while set DND on user.', 'data' => ''));
                }
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'User has been already set on DND.', 'data' => ''));
            }
        }
        return response()->json(array('type' => 'ERROR', 'message' => 'Invalid action perform.', 'data' => ''));
    }

    public function destroyUser(Request $request)
    {
        try {
            $exists = Customer::find($request->id);
            if ($exists) {
                try {
                    DB::transaction(function () use ($request) {
                        Customer::where('id', $request->id)->update(['is_delete' => 1]);
                    });
                    return response()->json(array('type' => 'SUCCESS', 'message' => 'Customer deleted successfully!', 'data' => ''));
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(array('type' => 'ERROR', 'message' => 'Deletion failed ' . $e->getMessage(), 'data' => ''));
                }
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Customer not found!', 'data' => ''));
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('type' => 'ERROR', 'message' => $e->getMessage(), 'data' => ''));
        }
    }

    public function convertCustomer(Request $request)
    {
        $request->validate([
            'regdate' => 'required',
            'amount' => 'required|numeric|between:0,9999.99',
            'paymentid' => 'required'
        ]);
        $userDetail = Customer::where('id', $request->input('user_id'))->first();
        /* registration date and date time */
        $regdate = date('Y-m-d', strtotime($request->input('regdate')));
        $regdatetime = date('Y-m-d', strtotime($request->input('regdate'))) . " " . date('H:i:s');

        $netamount = $cgstamount = $sgstamount = $igstamount = 0;
        $paymentid = 'cash_' . random_code(13);
        /* payment id if exists */
        if ($request->has('paymentid')) {
            $paymentid = $request->input('paymentid');
        }
        $paymentDetail = new \stdClass();
        $paymentDetail->payment_id = $paymentid;
        if (!empty($userDetail->order_id)) {
            $paymentDetail->order_id = $userDetail->order_id;
        } else {
            $paymentDetail->order_id = generateOrderId($userDetail->product->productslug);
        }

        if ($request->has('amount')) {
            $netamount = $request->input('amount');
            $userDetail->amount = $netamount;
            if ($userDetail->state == 'Gujarat') {
                $cgstamount = $netamount * 0.09;
                $sgstamount = $netamount * 0.09;
            } else {
                $igstamount = $netamount * 0.18;
            }
            $userDetail->grand_total = $netamount + $cgstamount + $sgstamount + $igstamount;
        }

        $originalUserData = [
            'created_at' => $userDetail->created_at,
            'refcode' => $userDetail->refcode,
            'process_step' => $userDetail->process_step,
            'order_id' => $userDetail->order_id,
            'is_user' => $userDetail->is_user,
        ];
        try {
            DB::transaction(function () use ($userDetail, $paymentDetail) {
                $updateData = [
                    'is_user'  => 1,
                    'process_step'  => 5,
                    'order_id' => $paymentDetail->order_id,
                    'refcode' => generateRefCode($userDetail->first_name),
                ];
                $userDetail->update($updateData);
            });

            $invoiceService = app(InvoiceService::class);
            $invoice = $invoiceService->createInvoice($userDetail, $paymentDetail);
            app(SmsService::class)->sendPaymentSuccess($userDetail);
            app(MailService::class)->sendPaymentSuccessMail($userDetail, $invoice);
            $interaktService = app(InteraktService::class);
            $template_name = $interaktService->getInteraktSuccessTemplate($userDetail->product_id);
            $interaktService->sendMessage($userDetail, $template_name);

            return response()->json(array('type' => 'SUCCESS', 'message' => 'Leads convert into customer successfully!', 'data' => ''));
        } catch (\Exception $e) {
            Log::error('convertCustomer', ["message" => $e->getMessage(), "trace" => $e->getTraceAsString()]);
            Customer::where('id', $userDetail->id)
                ->update($originalUserData);
            return response()->json(array('type' => 'ERROR', 'message' => $e->getMessage(), 'data' => ''));
        }
    }
}
