<?php

namespace Modules\ImportantUpdate\App\Http\Controllers;

use App\DataTables\ImportantUpdateDataTable;
use App\Http\Controllers\Controller;
use App\Models\ImportantUpdate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImportantUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ImportantUpdateDataTable $dataTable)
    {
        return $dataTable->render('importantupdate::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('importantupdate::modals.addUpdates');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'tags' => 'required',
            'descriptions' => 'required',
        ]);
        $result = ImportantUpdate::create($input);
        $message = 'Important Updates Successfully Added';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }

    /**
     * Show the specified resource.
     */
    public function statusChange(Request $request)
    {
        $input = $request->all();
        $result = ImportantUpdate::where('id', $input['id'])->first();
        ImportantUpdate::where('id', $result['id'])->update(['isActive' => $input['status'] == 1 ? 0 : 1]);
        $message = 'Status changed successfully';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $result = ImportantUpdate::where('id', $id)->first();
        return view('importantupdate::modals.editUpdates', [
            'data' => $result,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $oldResult = ImportantUpdate::where('id', $input['id'])->first();
        $request->validate([
            'tags' => 'required',
            'descriptions' => 'required'
        ]);
        $result = ImportantUpdate::where('id', $input['id'])->update($input);
        $message = 'Important Updates Successfully Updated';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $result = ImportantUpdate::where('id', $input['id'])->first();
        if ($result) {
            ImportantUpdate::where('id', $result['id'])->update(['isDelete' => 1]);
            $message = 'Important Update record Deleted Successfully';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }
}
