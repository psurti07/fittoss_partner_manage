<?php

namespace Modules\SiteOptions\App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class FacebookSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = DB::table('fb_products_data as fpd')
            ->select('fpd.id', 'fpd.rec_date', 'fpd.productid', 'fpd.domain_key', 'fpd.pixel_key', 'fpd.event_name', 'fpd.event_id', 'fpd.access_token','fpd.updated_at', 'p.product_title')
            ->join('products as p', 'fpd.productid', '=', 'p.id')
            ->orderBy('fpd.updated_at', 'desc')
            ->get();
        return view('siteoptions::facebook.index', compact('data'));
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
