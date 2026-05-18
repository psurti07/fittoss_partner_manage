<?php

namespace Modules\OfferUser\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\UserPersonalDetails;
use App\Services\BMIService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomersController extends Controller
{
    public function wloCustomers(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search')['value'] ?? NULL;
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
                'updated_at'
            )
                ->where('is_user', 1)
                ->where('is_delete', 0)
                ->where('product_id', config('constant.WEIGHT_LOSS_OFFER_ID'));
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
            $data = $query->orderByDesc('id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at)) . '<br>' . date('h:i:s A', strtotime($row->updated_at));
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="" href="' . route('manage.customers.details', ['userId' => $row->id]) . '"><i class="fa fa-info-circle"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('offeruser::weight-loss-offer.customers');
    }

    public function UPCustomers(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search')['value'] ?? NULL;
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
                'updated_at'
            )
                ->where('is_user', 1)
                ->where('is_delete', 0)
                ->where('product_id', config('constant.ULTIMATE_PROGRAM_ID'));
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
            $data = $query->orderByDesc('id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at)) . '<br>' . date('h:i:s A', strtotime($row->updated_at));
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="" href="' . route('manage.customers.details', ['userId' => $row->id]) . '"><i class="fa fa-info-circle"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('offeruser::ultimate-program.customers');
    }


    public function CPCustomers(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search')['value'] ?? NULL;
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
                'updated_at'
            )
                ->where('is_user', 1)
                ->where('is_delete', 0)
                ->where('product_id', config('constant.CUSTOMIZE_PROGRAM_ID'));
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
            $data = $query->orderByDesc('id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at)) . '<br>' . date('h:i:s A', strtotime($row->updated_at));
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="" href="' . route('manage.customers.details', ['userId' => $row->id]) . '"><i class="fa fa-info-circle"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('offeruser::customize-program.customers');
    }

    // weight loss webinar offer customers
    public function WLWOCustomers(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search')['value'] ?? NULL;
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
                'updated_at'
            )
                ->where('is_user', 1)
                ->where('is_delete', 0)
                ->where('product_id', config('constant.WEIGHT_LOSS_WEBINAR_OFFER_ID'));
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
            $data = $query->orderByDesc('id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at)) . '<br>' . date('h:i:s A', strtotime($row->updated_at));
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="" href="' . route('manage.customers.details', ['userId' => $row->id]) . '"><i class="fa fa-info-circle"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('offeruser::weight-loss-webinar-offer.customers');
    }


    public function usersDetails($userId)
    {
        $customer = Customer::where(['id' => $userId, 'is_delete' => 0, 'is_user' => 1])->first();
        $invoices = Invoice::where('userid', $userId)->get();
        $referralUsers = [];

        if ($customer != null) {
            $redirectRoute = "";
            if ($customer->product_id == config('constant.WEIGHT_LOSS_OFFER_ID')) {
                $redirectRoute = route('manage.weight-loss-offer.customers');
            } elseif ($customer->product_id == config('constant.FITONE_OFFER_ID')) {
                $redirectRoute = route('manage.fitone.customers');
            } elseif ($customer->product_id == config('constant.EXPERT_CONSULTATION_OFFER_ID')) {
                $redirectRoute = route('manage.expert.consultation.customers');
            } elseif ($customer->product_id == config('constant.ADVANCE_PLAN_OFFER_ID')) {
                $redirectRoute = route('manage.advance-plan.customers');
            } elseif ($customer->product_id == config('constant.ASSOCIATE_PARTNER_PROGRAM_OFFER_ID')) {
                $redirectRoute = route('manage.associate-partner-program.customers');
            } elseif ($customer->product_id == config('constant.MEMBERSHIP_PLAN_OFFER_ID')) {
                $redirectRoute = route('manage.membership-plan.customers');
            } elseif ($customer->product_id == config('constant.ONBOARD_UPI_PAYMENT_OFFER_ID')) {
                $redirectRoute = route('manage.onboard-upi-payment.customers');
            } elseif ($customer->product_id == config('constant.HEALTH_COACH_WEBINAR_PRODUCT_ID')) {
                $redirectRoute = route('manage.health-coach-webinar.customers');
            } elseif ($customer->product_id == config('constant.WEIGHT_LOSS_WEBINAR_OFFER_ID')) {
                $redirectRoute = route('manage.weight-loss-webinar-offer.customers');
            }
            return view('offeruser::customerDetails', compact(['customer', 'invoices', 'referralUsers', 'redirectRoute']));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Users not found!', 'data' => ''));
        }
    }

    public function usersDetailsUpdate(Request $request)
    {
        $companyId = $request->company_id;
        $userId = $request->input('userid');
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            // 'email' => 'required|email|unique:customers,email,' . $userId . ',id,product_id,' . config('constant.WEIGHT_LOSS_PROGRAM_ID'),
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
            'company_id' => $companyId,
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
}
