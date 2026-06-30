<?php

namespace Modules\DND\App\Http\Controllers;

use App\DataTables\DndListDataTable;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DNDController extends Controller
{
    public function index(DndListDataTable $dataTable, $type)
    {
        return $dataTable->with('type', $type)->render('dnd::index');
    }

    public function processCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $mobileNumbers = [];

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            $header = fgetcsv($handle);
            $mobileColumnIndex = array_search('mobile', array_map('strtolower', $header));

            if ($mobileColumnIndex === false) {
                return response()->json(['error' => 'Mobile number column not found'], 400);
            }

            while (($row = fgetcsv($handle)) !== false) {
                if (isset($row[$mobileColumnIndex])) {
                    $mobileNumbers[] = trim($row[$mobileColumnIndex]);
                }
            }
            fclose($handle);
        }

        $updatedCount = Customer::whereIn('mobile_no', $mobileNumbers)
            ->where('company_id', $request->company_id)
            ->update(['is_dnd' => 1]);
        return response()->json([
            'message' => "$updatedCount records updated successfully!",
            'updated_count' => $updatedCount
        ]);
    }

    public function destroy(Request $request)
    {
        try {
            $inputs = $request->all();
            $rec = Customer::where('id', $inputs['id'])->first();
            if ($rec) {
                $updRec = Customer::where('id', $inputs['id'])->update(['is_dnd' => 0]);
                if ($updRec) {
                    return response()->json(['type' => 'SUCCESS', 'message' => 'Record removed from DND successfully!']);
                } else {
                    return response()->json(['type' => 'ERROR', 'message' => 'Oops! Something went wrong while removing the record.']);
                }
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'Record not found to remove from DND.']);
            }
        } catch (\Exception $e) {
            return response()->json(['type' => 'ERROR', 'message' => 'Oops! Something went wrong.']);
        }
    }
}
