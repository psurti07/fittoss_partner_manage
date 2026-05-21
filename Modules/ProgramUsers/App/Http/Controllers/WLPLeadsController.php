<?php

namespace Modules\ProgramUsers\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\OtpVerification;
use App\Services\InteraktService;
use App\Services\InvoiceService;
use App\Services\MailService;
use App\Services\SmsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class WLPLeadsController extends Controller
{
    public function statistics()
    {
        $data = Customer::whereDate('updated_at', now())
            ->where('product_id', config('constant.WEIGHT_LOSS_PROGRAM_ID'))
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->selectRaw("SUM(CASE WHEN is_user = 0 THEN 1 ELSE 0 END) as leads,
                         SUM(CASE WHEN is_user = 1 THEN 1 ELSE 0 END) as customers,
                         SUM(CASE WHEN is_user = 1 THEN grand_total ELSE 0 END) as amount")
            ->first();

        $otps = OtpVerification::where('product_id', config('constant.WEIGHT_LOSS_PROGRAM_ID'))
            ->whereDate('updated_at', now())
            ->count();

        $leads = $data->leads ?? 0;
        $customers = $data->customers ?? 0;
        $amount = $data->amount ?? 0;
        return view('programusers::weight-loss-program.statistics', compact('leads', 'customers', 'amount', 'otps'));
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
                ->where('product_id', config('constant.WEIGHT_LOSS_PROGRAM_ID'));
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
        return view('programusers::weight-loss-program.leads');
    }

    public function info(Request $request)
    {
        $userDetails = Customer::with('personalDetails')->where('id', $request->input('infoId'))->first();
        $userOtps = OtpVerification::select('mobile', 'otp_code', 'rec_date')->where('mobile', $userDetails->mobile_no)->orderByDesc('id')->get();
        $rec['details'] = $userDetails;
        $rec['otps'] = $userOtps;
        return view('programusers::weight-loss-program.infodetails')->with($rec);
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
            'is_paid' => $userDetail->is_paid,
        ];
        try {
            DB::transaction(function () use ($userDetail, $paymentDetail) {
                $updateData = [
                    'is_paid'  => 1,
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
