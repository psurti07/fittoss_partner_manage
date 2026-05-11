<?php

namespace Modules\RemarketingLog\App\Http\Controllers;

use App\DataTables\RemarketingLogDataTable;
use App\Http\Controllers\Controller;
use App\Models\SmsLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RemarketingLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RemarketingLogDataTable $dataTable)
    {
        return $dataTable->render('remarketinglog::index');
    }

    public function details($remarketingId){
        $data = SmsLog::findOrFail($remarketingId);
        return view('remarketinglog::details', compact('data'));
    }

}
