<?php

namespace Modules\Invoice\App\Http\Controllers;

use App\DataTables\InvoiceDataTable;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\EventCustomer;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function getInvoices(InvoiceDataTable $dataTable)
    {
        return $dataTable->render('invoice::invoices');
    }

    public function getRefunds(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search')['value'] ?? NULL;
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $queryRes = DB::table('refunds as r')
                ->join('customers as c', 'c.id', 'r.user_id')
                ->selectRaw('r.id,
                r.ref_number,
                r.created_at,
                r.ref_price,
                r.ref_cgst,
                r.ref_sgst,
                r.ref_igst,
                r.ref_grandtotal,
                r.paymentid,
                CONCAT(c.first_name," ",c.last_name) as fullname,
                c.mobile_no,
                c.email,
                c.city,
                c.state')
                ->where('r.is_delete', 0)
                ->where('r.company_id', $request->company_id)
                ->orderByDesc('r.created_at');
            if (!empty($fromDate) && !empty($toDate)) {
                $fromDate = Carbon::parse($fromDate)->startOfDay();
                $toDate = Carbon::parse($toDate)->endOfDay();
                $queryRes->whereBetween('r.created_at', [$fromDate, $toDate]);
            }
            if (!empty($search)) {
                $queryRes->where(function ($q) use ($search) {
                    $q->where('r.ref_number', 'like', "%{$search}%")
                        ->orWhere('r.paymentid', 'like', "%{$search}%")
                        ->orWhere('c.mobile_no', 'like', "%{$search}%")
                        ->orWhere('c.city', 'like', "%{$search}%")
                        ->orWhere('c.first_name', 'like', "%{$search}%")
                        ->orWhere('c.last_name', 'like', "%{$search}%")
                        ->orWhere('c.state', 'like', "%{$search}%");
                });
            }
            $refundData = $queryRes->get();
            return DataTables::of($refundData)
                ->addIndexColumn()
                ->make(true);
        }
        return view('invoice::refunds');
    }

    public function getGST(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search')['value'] ?? NULL;
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $queryRes = Invoice::from('invoices')
                ->join('customers as c', 'c.id', 'invoices.userid')
                ->selectRaw('invoices.*,
                CONCAT(c.first_name," ",c.last_name) as fullname,
                c.mobile_no,
                c.email,
                c.city,
                c.state')
                ->where('invoices.is_delete', 0)
                ->company()
                ->orderByDesc('invoices.created_at');
            if (!empty($fromDate) && !empty($toDate)) {
                $fromDate = Carbon::parse($fromDate)->startOfDay();
                $toDate = Carbon::parse($toDate)->endOfDay();
                $queryRes->whereBetween('invoices.inv_date', [$fromDate, $toDate]);
            }
            if (!empty($search)) {
                $queryRes->where(function ($q) use ($search) {
                    $q->where('invoices.payment_id', 'like', "%{$search}%")
                        ->orWhere('invoices.inv_number', 'like', "%{$search}%")
                        ->orWhere('c.mobile_no', 'like', "%{$search}%")
                        ->orWhere('c.city', 'like', "%{$search}%")
                        ->orWhere('c.first_name', 'like', "%{$search}%")
                        ->orWhere('c.last_name', 'like', "%{$search}%")
                        ->orWhere('c.state', 'like', "%{$search}%");
                });
            }
            $invoiceData = $queryRes->get();

            return DataTables::of($invoiceData)
                ->addIndexColumn()
                ->addColumn('inv_date', function ($row) {
                    return date('Y-m-d', strtotime($row['inv_date']));
                })
                ->addColumn('inv_no', function ($row) {
                    return $row['inv_prefix'] . '' . $row['inv_number'];
                })
                ->addColumn('fullname', function ($row) {
                    return $row['fullname'];
                })
                ->addColumn('city', function ($row) {
                    return $row['city'];
                })
                ->addColumn('state', function ($row) {
                    return $row['state'];
                })
                ->rawColumns(['inv_date', 'inv_no', 'fullname', 'city', 'state'])
                ->make(true);
        }
        return view('invoice::gst');
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
        if ($invoice->user_type == 1) {
            $pdf = Pdf::loadView('invoice.invoice_pdf', $invoiceData)->setPaper('a4', 'portrait');
            return $pdf->download('invoice-' . $invoice->order_id . '.pdf');
            // return $pdf->stream('invoice.pdf');
        }

        $eventDetail = EventCustomer::with('event:title,id')->where('order_id', $invoice->order_id)->first();
        $invoiceData['event_title'] = $eventDetail->event->title ?? 'N/A';
        $pdf = Pdf::loadView('invoice.event_invoice_pdf', $invoiceData)->setPaper('a4', 'portrait');
        return $pdf->download('invoice-' . $invoice->order_id . '.pdf');
    }

    public function generateInvoice($id)
    {
        $invoice = Invoice::with('user')
            ->where('id', $id)
            ->firstOrFail();
        $invoiceData = [
            'invoice' => $invoice,
            'user' => $invoice->user
        ];
        if ($invoice->user_type == 1) {
            return view('invoice.invoice', $invoiceData);
        }

        $eventDetail = EventCustomer::with('event:title,id')->where('order_id', $invoice->order_id)->first();
        $invoiceData['event_title'] = $eventDetail->event->title ?? 'N/A';
        return view('invoice.event_invoice', $invoiceData);
    }

    public function refundProcess($invId, $invNo)
    {
        return view('invoice::modals.refund', compact('invId', 'invNo'));
    }

    public function refundAmtProcess(Request $request)
    {
        try {
            $request->validate([
                'paymentid' => 'required'
            ]);

            $invData = Invoice::where('id', $request->invoiceid)->first();
            if ($invData) {
                $refundNumber = date('md') . random_code_num(6);
                $data = array(
                    'user_id' => $invData->userid,
                    'company_id' => $invData->company_id,
                    'invoice_id' => $invData->id,
                    'ref_number' => $refundNumber,
                    'ref_price' => $invData->inv_price,
                    'ref_cgst' => $invData->inv_cgst,
                    'ref_sgst' => $invData->inv_sgst,
                    'ref_igst' => $invData->inv_igst,
                    'ref_grandtotal' => $invData->inv_grandtotal,
                    'paymentid' => $request->paymentid,
                    'remarks' => $request->remarks,
                    'is_delete' => 0
                );
                DB::table('refunds')->insert($data);
                Invoice::where('id', $invData->id)->update(['is_refund' => 1, 'remarks' => $request->remarks,]);
                Customer::where('id', $invData->userid)->update(['is_active' => 0]);
                return response()->json(['type' => 'SUCCESS', 'message' => 'Refund successfully placed']);
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'Opps! Invoice not found.']);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['type' => 'ERROR', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::info('error occured in refund module - ' . $e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Oops! Something went wrong while process refund']);
        }
    }

    public function deleteInvoice($id)
    {
        try {
            Invoice::where('id', $id)->update(['is_delete' => 1]);
            return response()->json(['type' => 'success', 'message' => 'Invoice deleted successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('deleteInvoice', ['message' => $e->getMessage()]);
            return response()->json(['type' => 'error', 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }
}
