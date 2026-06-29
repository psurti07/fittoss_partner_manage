<?php

namespace Modules\OfferUser\Http\Controllers;

use App\Models\Customer;
use App\Models\OtpVerification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\InteraktService;
use App\Services\InvoiceService;
use App\Services\MailService;
use App\Services\SmsService;
use Illuminate\Support\Facades\Log;

class LeadsController extends Controller
{
    public function wloLeads(Request $request)
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
                ->where('is_user', 0)
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
                    $actionBtn = '<ul class="action" style="display:block">
                                    <li class="info" style="display: flex;align-items: center;justify-content: center;"> <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')"><i class="fa fa-info-circle"></i></a></li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('offeruser::weight-loss-offer.leads');
    }
    public function UPLeads(Request $request)
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
                ->where('is_user', 0)
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
                    $actionBtn = '<ul class="action" style="display:block">
                                    <li class="info" style="display: flex;align-items: center;justify-content: center;"> <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')"><i class="fa fa-info-circle"></i></a></li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('offeruser::ultimate-program.leads');
    }

    public function CPLeads(Request $request)
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
                ->where('is_user', 0)
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
                    $actionBtn = '<ul class="action" style="display:block">
                                    <li class="info" style="display: flex;align-items: center;justify-content: center;"> <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')"><i class="fa fa-info-circle"></i></a></li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('offeruser::customize-program.leads');
    }

    // weight loss webinar offer leads
    public function WLWOLeads(Request $request)
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
                ->where('is_user', 0)
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
                    $actionBtn = '<ul class="action" style="display:block">
                                    <li class="info" style="display: flex;align-items: center;justify-content: center;"> <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')"><i class="fa fa-info-circle"></i></a></li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('offeruser::weight-loss-webinar-offer.leads');
    }

    // child nutrition offer leads
    public function CNLeads(Request $request)
    {
        if ($request->ajax()) {
            $columns = Customer::DATATABLE_COLUMNS;
            $search = $request->input('search')['value'] ?? NULL;
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            $query = Customer::query()
                ->baseCustomerQuery()
                ->userType(Customer::TYPE_LEAD)
                ->product(config('constant.CHILD_NUTRITION_OFFER_ID'))
                ->dateRange($fromDate, $toDate)
                ->search($search);

            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('customers.updated_at', 'desc');
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at)) . '<br>' . date('h:i:s A', strtotime($row->updated_at));
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<ul class="action justify-content-center">
                                    <li class="info"> <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')"><i class="fa fa-info-circle"></i></a></li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('offeruser::child-nutrition-offer.leads');
    }

    public function info(Request $request)
    {
        $customer = Customer::with('personalDetails')->where('id', $request->input('infoId'))->first();
        $rec['customer'] = $customer;
        $rec['otps'] = OtpVerification::select('mobile', 'otp_code', 'rec_date')->where('mobile', $customer->mobile_no)->orderByDesc('id')->get();;
        $tableId = "wloLeadsTable";
        if ($customer->product_id == config('constant.WEIGHT_LOSS_OFFER_ID')) {
            $tableId = "wloLeadsTable";
        } elseif ($customer->product_id == config('constant.ULTIMATE_PROGRAM_ID')) {
            $tableId = "UPLeadsTable";
        } elseif ($customer->product_id == config('constant.CUSTOMIZE_PROGRAM_ID')) {
            $tableId = "CPLeadsTable";
        } elseif ($customer->product_id == config('constant.FITONE_OFFER_ID')) {
            $tableId = "fitoneLeadTable";
        } elseif ($customer->product_id == config('constant.EXPERT_CONSULTATION_OFFER_ID')) {
            $tableId = "expertConsultLeadTable";
        } elseif ($customer->product_id == config('constant.ADVANCE_PLAN_OFFER_ID')) {
            $tableId = "advancePlanLeadTable";
        } elseif ($customer->product_id == config('constant.ASSOCIATE_PARTNER_PROGRAM_OFFER_ID')) {
            $tableId = "associatePartnerLeadTable";
        } elseif ($customer->product_id == config('constant.MEMBERSHIP_PLAN_OFFER_ID')) {
            $tableId = "membershipPlanLeadTable";
        } elseif ($customer->product_id == config('constant.HEALTH_COACH_WEBINAR_PRODUCT_ID')) {
            $tableId = "healthCoachWebinarLeadTable";
        } elseif ($customer->product_id == config('constant.WEIGHT_LOSS_WEBINAR_OFFER_ID')) {
            $tableId = "weightLossWebinarOfferLeadTable";
        } elseif ($customer->product_id == config('constant.CHILD_NUTRITION_OFFER_ID')) {
            $tableId = "childNutritionOfferLeadTable";
        }
        $rec['tableId'] = $tableId;
        return view('offeruser::infodetails')->with($rec);
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
            'updated_at' => $userDetail->updated_at,
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
