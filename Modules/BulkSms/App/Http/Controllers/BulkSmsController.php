<?php

namespace Modules\BulkSms\App\Http\Controllers;

use App\DataTables\BulkSmsDataTable;
use App\Http\Controllers\Controller;
use App\Models\BulkSms;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BulkSmsController extends Controller
{
    public function index(BulkSmsDataTable $dataTable)
    {
        return $dataTable->render('bulksms::index');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $records = [];
        $errors = [];
        $rowNumber = 1;

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {

            $header = array_map('strtolower', fgetcsv($handle));

            // Column indexes
            $fullnameIndex = array_search('fullname', $header);
            $mobileIndex   = array_search('mobile', $header);
            $emailIndex    = array_search('email', $header);

            if ($fullnameIndex === false || $mobileIndex === false || $emailIndex === false) {
                return response()->json([
                    'error' => 'CSV must contain fullname, mobile, and email columns'
                ], 400);
            }

            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;

                $input = [
                    'rec_date' => now()->format('Y-m-d'),
                    'company_id' => $request->company_id,
                    'fullname' => trim($row[$fullnameIndex] ?? ''),
                    'mobile'   => trim($row[$mobileIndex] ?? ''),
                    'email'    => strtolower(trim($row[$emailIndex] ?? '')),
                ];

                $validator = Validator::make($input, [
                    'fullname' => 'required|string',
                    'mobile'   => 'required|digits:10|regex:/^[6-9]\d{9}$/',
                    'email'    => 'nullable|email',
                ]);

                if ($validator->fails()) {
                    $errors[] = "Row $rowNumber: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $records[] = $input;
            }

            fclose($handle);
        }

        if (!empty($records)) {
            DB::table('bulksms')->upsert(
                $records,
                ['mobile', 'company_id'], // Unique column
                ['fullname', 'email', 'rec_date'] // Columns to update if exists
            );
        }

        return response()->json([
            'message' => count($records) . " Records processed successfully!",
            'processed_count' => count($records),
            'errors' => $errors,
        ]);
    }

    public function destroy(Request $request)
    {
        try {
            $inputs = $request->all();
            $bulkSmsId = BulkSms::find($inputs['id']);
            if ($bulkSmsId) {
                $res = Bulksms::where('id', $inputs['id'])->delete();
                if ($res) {
                    return response()->json(['type' => 'SUCCESS', 'message' => 'Record removed successfully!']);
                } else {
                    return response()->json(['type' => 'ERROR', 'message' => 'Record not deleted!']);
                }
            } else {
                return response()->json(['type' => 'ERROR', 'message' => 'Data not found to delete the record.']);
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['type' => 'ERROR', 'message' => 'Oops! Something went wrong.']);
        }
    }
}
