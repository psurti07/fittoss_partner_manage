<?php

namespace Modules\Remarketing\App\Http\Controllers;

use App\DataTables\RemarketingLogDataTable;
use App\Http\Controllers\Controller;
use App\Models\SmsLog;

class RemarketingLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RemarketingLogDataTable $dataTable)
    {
        return $dataTable->render('remarketing::index');
    }

    public function details($remarketingId){
        $data = SmsLog::findOrFail($remarketingId);
        return view('remarketing::details', compact('data'));
    }

}
