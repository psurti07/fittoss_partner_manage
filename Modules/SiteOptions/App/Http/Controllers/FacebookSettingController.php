<?php

namespace Modules\SiteOptions\App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FacebookSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $companyId = $request->company_id;
            $search = $request->input('search')['value'] ?? NULL;
            $productId = $request->input('product_id');
            $query = DB::table('fb_products_data as fpd')
                ->join('products as p', 'p.id', 'fpd.productid')
                ->select(
                    'fpd.id',
                    'fpd.rec_date',
                    'fpd.productid',
                    'fpd.domain_key',
                    'fpd.pixel_key',
                    'fpd.event_name',
                    'fpd.event_id',
                    'fpd.access_token',
                    'fpd.updated_at',
                    'p.product_title as product_name'
                )->where('fpd.company_id', $companyId);

            if (!empty($productId)) {
                $query->where('fpd.product_id', $productId);
            }
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('fpd.domain_key', 'like', "%{$search}%")
                        ->orWhere('p.product_title', 'like', "%{$search}%")
                        ->orWhere('fpd.pixel_key', 'like', "%{$search}%");
                });
            }
            $data = $query->orderBy('fpd.updated_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('updated_at', function ($row) {
                    return date('d-m-Y h:i:s A', strtotime($row->updated_at));
                })
                ->editColumn('access_token', function ($row) {
                    return substr($row->access_token, 0, 6) . '************' . substr($row->access_token, -6);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:;" class="editBtn" data-id="' . $row->id . '" data-domain="' . $row->domain_key . '" data-pixel="' . $row->pixel_key . '" data-token="' . $row->access_token . '" data-eventname="' . $row->event_name . '" data-eventid="' . $row->event_id . '">
                                    <i class="text-success icon-pencil-alt"></i>
                                  </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'updated_at', 'access_token'])
                ->make(true);
        }
        return view('siteoptions::facebook.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('siteoptions::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('siteoptions::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('siteoptions::edit');
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
            'id' => 'required',
            'access_token' => 'nullable',
            'event_id' => 'nullable',
            'event_name' => 'nullable',
            'pixel_key' => 'nullable',
            'domain_key' => 'nullable',
        ], [
            'access_token.required' => 'Facebook access token field is required',
            'event_id.required' => 'Facebook event id field is required',
            'event_name.required' => 'Facebook event name field is required',
            'pixel_key.required' => 'Facebook pixel key field is required',
            'domain_key.required' => 'Facebook domain key field is required',
        ]);

        DB::table('fb_products_data')->where('id', $request->id)->update([
            'domain_key' => $request->domain_key,
            'pixel_key' => $request->pixel_key,
            'access_token' => $request->access_token,
            'event_name' => $request->event_name,
            'event_id' => $request->event_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Facebook setting updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
