<?php

namespace Modules\Event\Http\Controllers;

use App\Models\Customer;
use App\Models\EventCustomer;
use App\Models\OtpVerification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LeadsController extends Controller
{
    public function leads(Request $request)
    {
        if ($request->ajax()) {
            $columns = EventCustomer::DATATABLE_COLUMNS;
            $search = $request->input('search')['value'] ?? NULL;
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $eventId = $request->input('event_id');

            $query = EventCustomer::from('event_customers as ec')
                ->baseCustomerQuery()
                ->userType(EventCustomer::TYPE_LEAD)
                ->event($eventId)
                ->dateRange($fromDate, $toDate)
                ->search($search);

            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('ec.updated_at', 'desc');
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
        return view('event::leads');
    }

    public function info(Request $request)
    {
        $eventCustomer = EventCustomer::with('user')->where('id', $request->input('infoId'))->first();
        $rec['customer'] = $eventCustomer->user;
        $rec['eventCustomer'] = $eventCustomer;
        $rec['otps'] = OtpVerification::select('mobile', 'otp_code', 'rec_date')->where('mobile', $eventCustomer->user->mobile_no)->orderByDesc('id')->get();;
        return view('event::infodetails')->with($rec);
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
        $regdate = Carbon::parse($request->regdate)->setTimeFrom(Carbon::now())->format('Y-m-d H:i:s');
        $eventCustomer = EventCustomer::with(['user', 'event:title,id'])->where('id', $request->input('event_user_id'))->first();
        $userDetail = $eventCustomer->user;

        $netamount = $cgstamount = $sgstamount = $igstamount = 0;
        $paymentid = 'cash_' . random_code(13);
        /* payment id if exists */
        if ($request->has('paymentid')) {
            $paymentid = $request->input('paymentid');
        }
        $paymentDetail = new \stdClass();
        $paymentDetail->payment_id = $paymentid;
        $paymentDetail->order_id = $eventCustomer->order_id;

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
            'is_user' => $userDetail->is_user,
        ];
        try {
            DB::transaction(function () use ($userDetail, $regdate) {
                $updateData = [
                    'is_user'  => 1,
                    'refcode' => generateRefCode($userDetail->first_name),
                    'created_at' => $regdate,
                    'updated_at' => $regdate
                ];
                $userDetail->update($updateData);
            });

            $eventCustomer->update([
                'is_user'  => 1,
                'created_at' => $regdate,
                'updated_at' => $regdate
            ]);

            $invoiceService = app(InvoiceService::class);
            $invoice = $invoiceService->createInvoice($userDetail, $paymentDetail);
            /**=== Mail == */
            $mailData = [
                'fullname' => trim($userDetail->first_name . ' ' . $userDetail->last_name),
                'email'    => $userDetail->email,
            ];

            $emailContent = view('front.events.emails.payment_success', [
                'name' => $mailData['fullname']
            ])->render();

            // Generate invoice PDF
            if ($invoice) {
                $invoiceData = [
                    'invoice' => $invoice,
                    'user' => $userDetail,
                    'event_title' => $eventCustomer->event->title ?? 'N/A'
                ];
                $invoiceHtml = view('invoice.event_invoice_pdf', $invoiceData)->render();
                $pdf = Pdf::loadHTML($invoiceHtml)->setPaper('A4', 'portrait')->output();
                $base64Pdf = base64_encode($pdf);

                // Prepare attachments
                $attachments = [
                    [
                        'content' => $base64Pdf,
                        'name' => 'Invoice_' . $invoice->inv_prefix . $invoice->inv_number . '.pdf'
                    ]
                ];
            }
            sendBrevoHtmlMail2($mailData, "Welcome to Fittoss – Event Registration", $emailContent, $attachments ?? []);
            /**=== Whatsapp == */
            /**=== SMS == */

            return response()->json(array('type' => 'SUCCESS', 'message' => 'Leads convert into customer successfully!', 'data' => ''));
        } catch (\Exception $e) {
            Log::error('convertCustomer', ["message" => $e->getMessage(), "trace" => $e->getTraceAsString()]);
            Customer::where('id', $userDetail->id)
                ->update($originalUserData);
            return response()->json(array('type' => 'ERROR', 'message' => $e->getMessage(), 'data' => ''));
        }
    }
}
