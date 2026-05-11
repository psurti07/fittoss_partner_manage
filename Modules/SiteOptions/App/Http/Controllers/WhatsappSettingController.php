<?php

namespace Modules\SiteOptions\App\Http\Controllers;

use App\Models\Product;
use App\Models\WhatsappSetting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WhatsappSettingController extends Controller
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
            $query = WhatsappSetting::from('whatsapp_settings as ws')
                ->leftJoin('products as p', 'p.id', 'ws.product_id')
                ->select(
                    'ws.id',
                    'ws.product_id',
                    'ws.event_name',
                    'ws.key',
                    'p.product_title as product_name',
                    'ws.template_name',
                    'ws.media_name',
                    'ws.media_url',
                    'ws.updated_at',
                );
            if (!empty($productId)) {
                $query->where('ws.product_id', $productId);
            }
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('ws.event_name', 'like', "%{$search}%")
                        ->orWhere('p.product_title', 'like', "%{$search}%")
                        ->orWhere('ws.template_name', 'like', "%{$search}%")
                        ->orWhere('ws.media_name', 'like', "%{$search}%");
                });
            }
            $data = $query->orderBy('ws.updated_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('updated_at', function ($row) {
                    return date('d-m-Y h:i:s A', strtotime($row->updated_at));
                })
                ->editColumn('event_name', function ($row) {
                    return '<span class="badge badge-light-primary">' . $row->event_name . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:;" class="editBtn" data-id="' . $row->id . '" data-key="' . $row->key . '" data-template_name="' . $row->template_name . '" data-media_name="' . $row->media_name . '" data-media_url="' . $row->media_url . '">
                                    <i class="text-success icon-pencil-alt"></i>
                                  </a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'event_name', 'updated_at'])
                ->make(true);
        }
        $products = Product::select('id', 'product_title')->get();
        return view('siteoptions::whatsapp.index', compact('products'));
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
            'id' => 'required|exists:whatsapp_settings,id',
            'key' => 'required',
            'template_name' => 'required',
            'media_name' => 'nullable',
            'media_url' => 'nullable',
        ], [
            'key.required' => 'Whatsapp key field is required',
            'template_name.required' => 'Whatsapp template name field is required',
            'media_name.required' => 'Whatsapp media name field is required',
            'media_url.required' => 'Whatsapp media url field is required',
        ]);

        WhatsappSetting::where('id', $request->id)->update([
            'key' => $request->key,
            'template_name' => $request->template_name,
            'media_name' => $request->media_name ?? null,
            'media_url' => $request->media_url ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Whatsapp setting updated successfully'
        ]);
    }
}
