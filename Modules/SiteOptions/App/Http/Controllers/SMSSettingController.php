<?php

namespace Modules\SiteOptions\App\Http\Controllers;

use App\Models\Product;
use App\Models\SMSSetting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SMSSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search')['value'] ?? NULL;
            $productId = $request->input('product_id');
            $query = SMSSetting::from('sms_settings as ss')
                ->leftJoin('products as p', 'p.id', 'ss.product_id')
                ->select(
                    'ss.id',
                    'ss.product_id',
                    'ss.sender_id',
                    'ss.remarketing_sender_id',
                    'p.product_title as product_name',
                    'ss.updated_at',
                );
            if (!empty($productId)) {
                $query->where('ss.product_id', $productId);
            }
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('ss.sender_id', 'like', "%{$search}%")
                        ->orWhere('p.product_title', 'like', "%{$search}%")
                        ->orWhere('ss.remarketing_sender_id', 'like', "%{$search}%");
                });
            }
            $data = $query->orderBy('ss.updated_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('updated_at', function ($row) {
                    return date('d-m-Y h:i:s A', strtotime($row->updated_at));
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:;" class="editBtn" data-id="' . $row->id . '" data-sender_id="' . $row->sender_id . '" data-remarketing_sender_id="' . $row->remarketing_sender_id . '">
                                    <i class="text-success icon-pencil-alt"></i>
                                  </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'updated_at'])
                ->make(true);
        }
        $products = Product::select('id', 'product_title')->get();
        return view('siteoptions::sms.index', compact('products'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sms_settings,id',
            'sender_id' => 'nullable',
            'remarketing_sender_id' => 'nullable',
        ]);

        SMSSetting::where('id', $request->id)->update([
            'sender_id' => $request->sender_id,
            'remarketing_sender_id' => $request->remarketing_sender_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'SMS setting updated successfully'
        ]);
    }
}
