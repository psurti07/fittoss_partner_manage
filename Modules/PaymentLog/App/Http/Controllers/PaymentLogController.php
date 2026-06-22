<?php

namespace Modules\PaymentLog\App\Http\Controllers;

use App\Enums\EntryFor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PaymentLogController extends Controller
{
    public function index(Request $request)
    {
        $routeTable = Route::current()->uri();
        switch ($routeTable) {
            case 'payu-log':
                $table = 'payu_logs as p';
                break;
            case 'paytm-log':
                $table = 'paytm_logs as p';
                break;
            case 'sabpaisa-log':
                $table = 'sabpaisa_log as p';
                break;
            case 'phonepay-log':
                $table = 'phonepay_logs as p';
                break;
            case 'vegaah-log':
                $table = 'vegaah_logs as p';
                break;
            case 'paygic-log':
                $table = 'paygic_logs as p';
                break;
            case 'ccavenue-log':
                $table = 'ccavenue_logs as p';
                break;
            case 'cipherpay-log':
                $table = 'cipherpayentry as p';
                break;
            case 'lyra-log':
                $table = 'lyra_entry as p';
                break;
            case 'zaakpay-log':
                $table = 'zaakpay_entry as p';
                break;
            default:
                $table = 'payu_logs as p';
                break;
        }

        if ($request->ajax()) {
            $companyId = $request->company_id;
            $columns = [
                0 => 'p.id',
                1 => 'p.rec_date',
                2 => 'p.entry_for',
                3 => 'c.first_name',
                4 => 'c.mobile_no',
                5 => 'c.email',
                6 => 'p.order_id',
                7 => 'p.grand_amount',
                8 => 'p.order_note',
                9 => 'p.tx_status'
            ];
            $search = $request->input('search')['value'] ?? NULL;
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');

            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            $query = DB::table($table)
                ->select(
                    'p.id',
                    'p.rec_date',
                    'p.entry_for',
                    'p.user_id',
                    'p.order_id',
                    'p.grand_amount',
                    'p.order_note',
                    'p.tx_status',
                    'c.first_name',
                    'c.last_name',
                    'c.mobile_no',
                    'c.email'
                )
                ->where('p.company_id', $companyId)
                ->join('customers as c', 'p.user_id', '=', 'c.id');

            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereRaw('DATE(p.rec_date)  BETWEEN  ? AND ?', [$fromDate, $toDate]);
            };
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('p.order_id', 'like', "%{$search}%")
                        ->orWhere('p.grand_amount', 'like', "%{$search}%")
                        ->orWhere('p.order_note', 'like', "%{$search}%")
                        ->orWhere('p.tx_status', 'like', "%{$search}%")
                        ->orWhere('c.last_name', 'like', "%{$search}%")
                        ->orWhere('c.mobile_no', 'like', "%{$search}%")
                        ->orWhere('c.email', 'like', "%{$search}%");
                });
            }
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('p.updated_at', 'desc');
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('rec_date', function ($row) {
                    return date('d-m-Y H:i:s', strtotime($row->rec_date));
                })
                ->addColumn('fullname', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('mobile', function ($row) {
                    return $row->mobile_no ?? 'N/A';
                })
                ->addColumn('email', function ($row) {
                    return $row->email ?? 'N/A';
                })
                ->editColumn('entry_for', function ($row) {
                    return EntryFor::tryFrom($row->entry_for)?->label() ?? '-';
                })
                ->make(true);
        }
        return view('paymentlog::index', compact('routeTable'));
    }
}
