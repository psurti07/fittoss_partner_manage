<?php

namespace Modules\SendOtp\App\Http\Controllers;

use App\DataTables\SendOtpDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;

class SendOtpController extends Controller
{
    public function index(SendOtpDataTable $dataTable)
    {
        return $dataTable->render('sendotp::index');
    }
}
