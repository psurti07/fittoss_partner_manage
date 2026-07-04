<?php

namespace Modules\Remarketing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Remarketing\App\Models\RemarketingSchedule;
use Yajra\DataTables\Facades\DataTables;

class RemarketingScheduleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                0 => 'id',
                1 => 'product_title',
            ];
            $search = $request->input('search')['value'] ?? null;
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');

            $query = Product::select('id', 'product_title');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('product_title', 'like', "%{$search}%");
                });
            }
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('updated_at', 'desc');
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('product_title', function ($row) {
                    return '<span class="text-muted">' . $row->product_title . '</span>';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="btn-group" role="group" aria-label="Actions">
                                <a class="btn btn-sm btn-primary" href="' . route('manage.remarketing.schedule.create', ['id' => $row->id]) . '">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['product_title', 'action'])
                ->make(true);
            // $columns = [
            //     0 => 's.product_id',
            //     1 => 'p.product_title',
            // ];
            // $search = $request->input('search')['value'] ?? null;
            // $orderColumnIndex = $request->input('order.0.column');
            // $orderDir = $request->input('order.0.dir', 'asc');

            // $query = RemarketingSchedule::from('remarketing_schedules as s')
            //     ->join('products as p', 's.product_id', '=', 'p.id')
            //     ->select('s.product_id', 's.type', 'p.product_title')
            //     ->groupBy('s.product_id', 's.type', 'p.product_title');

            // if (!empty($search)) {
            //     $query->where(function ($q) use ($search) {
            //         $q->where('p.product_title', 'like', "%{$search}%");
            //     });
            // }
            // if (isset($columns[$orderColumnIndex])) {
            //     $query->orderBy($columns[$orderColumnIndex], $orderDir);
            // } else {
            //     $query->orderBy('updated_at', 'desc');
            // }

            // return DataTables::of($query)
            //     ->addIndexColumn()
            //     ->editColumn('product_title', function ($row) {
            //         return '<span class="text-muted">' . $row->product_title . '</span>';
            //     })
            //     ->editColumn('type', function ($row) {
            //         if ($row->type == 1) {
            //             return '<span class="text-muted">Whatsapp</span>';
            //         }

            //         return '<span class="text-muted">SMS</span>';
            //     })
            //     ->addColumn('action', function ($row) {
            //         return '<div class="btn-group" role="group" aria-label="Actions">
            //                     <a class="btn btn-sm btn-primary" href="' . route('manage.remarketing.schedule.edit', ['product_id' => $row->product_id, 'type' => $row->type]) . '">
            //                         <i class="fa fa-edit"></i>
            //                     </a>
            //                 </div>';
            //     })
            //     ->rawColumns(['product_title', 'type', 'action'])
            //     ->make(true);
        }

        return view('remarketing::remarketings');
    }

    public function create(Request $request, int $id)
    {
        DB::enableQueryLog();
        $product = Product::select('id', 'product_title')->where('id', $id)->first();
        $whatsappSchedules = RemarketingSchedule::where('product_id', $product->id)
            ->company()
            ->where('type', 1)
            ->orderBy('day')
            ->get();
        $smsSchedules = RemarketingSchedule::where('product_id', $product->id)
            ->company()
            ->where('type', 2)
            ->orderBy('day')
            ->get();
        return view(
            'remarketing::remarketing_edit',
            compact('product', 'whatsappSchedules', 'smsSchedules')
        );
    }

    /* public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:1,2',
            'schedules' => 'required|array|min:1',
            'schedules.*.day' => 'required|integer|min:0',
            'schedules.*.time' => 'required|date_format:H:i|not_in:00:00',
        ], [
            'schedules.*.day' => 'Please select a valid day.',
            'schedules.*.time.required' => 'Please select a valid time.',
            'schedules.*.time.date_format' => 'Please select a valid time.',
            'schedules.*.time.not_in' => 'Please select a valid time.',
        ]);

        $insertData = [];

        foreach ($request->input('schedules', []) as $schedule) {
            $insertData[] = [
                'product_id' => (int) $request->product_id,
                'type' => (int) $request->type,
                'day' => (int) ($schedule['day'] ?? 0),
                'time' => $schedule['time'] ?? null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        RemarketingSchedule::insert($insertData);

        return redirect()->route('manage.remarketing.schedule.index')->with('success', 'Schedules Created');
    }

    public function edit(int|string $product_id, int|string $type)
    {
        $products = Product::select('id', 'product_title')->get();
        $whatsappSchedules = RemarketingSchedule::where('product_id', $product_id)
            ->where('type', 1)
            ->orderBy('day')
            ->get();
        $smsSchedules = RemarketingSchedule::where('product_id', $product_id)
            ->where('type', 2)
            ->orderBy('day')
            ->get();

        return view(
            'remarketing::remarketing_edit',
            compact('products', 'whatsappSchedules', 'smsSchedules', 'type', 'product_id')
        );
    }*/

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:1,2',
            'schedules' => 'required|array|min:1',
            'schedules.*.day' => 'required|integer|min:0',
            'schedules.*.time' => 'required|date_format:H:i|not_in:00:00',
        ], [
            'schedules.*.day' => 'Please select a valid day.',
            'schedules.*.time.required' => 'Please select a valid time.',
            'schedules.*.time.date_format' => 'Please select a valid time.',
            'schedules.*.time.not_in' => 'Please select a valid time.',
        ]);

        if ($request->filled('deleted_ids')) {
            $deletedIds = is_array($request->deleted_ids)
                ? $request->deleted_ids
                : explode(',', (string) $request->deleted_ids);

            RemarketingSchedule::whereIn('id', array_filter(array_map('trim', $deletedIds)))->delete();
        }

        $data = [];

        foreach ($request->input('schedules', []) as $schedule) {
            $data[] = [
                'id' => $schedule['id'] ?? null,
                'company_id' => $request->company_id,
                'product_id' => (int) $request->product_id,
                'type' => (int) $request->type,
                'day' => (int) ($schedule['day'] ?? 0),
                'time' => $schedule['time'] ?? null,
                'is_active' => (int) ($schedule['is_active'] ?? 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        RemarketingSchedule::upsert(
            $data,
            ['id', 'company_id'],
            [
                'company_id',
                'product_id',
                'day',
                'time',
                'type',
                'is_active',
                'updated_at',
            ]
        );

        return redirect()->route('manage.remarketing.schedule.create', ['id' => $request->product_id])->with('success', 'Schedules Updated');
    }
}
