<?php

namespace Modules\ProgramUsers\App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class LeadsController extends Controller
{
    // Health Coach Webinar
    public function hcwLeads(Request $request)
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
                'updated_at'
            )
                ->where('is_user', 0)
                ->where('is_delete', 0)
                ->where('product_id', config('constant.HEALTH_COACH_WEBINAR_PRODUCT_ID'));
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
                ->addColumn('action', function ($row) {
                    $actionBtn = '<ul class="action" style="display:block">
                                    <li class="info" style="display: flex;align-items: center;justify-content: center;"> <a href="javascript:;" onclick="openInfoModal(' . $row->id . ')"><i class="fa fa-info-circle"></i></a></li>
                                </ul>';
                    return $actionBtn;
                })
                ->rawColumns(['date', 'fullname', 'action'])
                ->make(true);
        }
        return view('programusers::health-coach-webinar.leads');
    }
}
