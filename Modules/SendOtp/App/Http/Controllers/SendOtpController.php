<?php

namespace Modules\SendOtp\App\Http\Controllers;

use App\DataTables\SendOtpDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;

class SendOtpController extends Controller
{
    public function index(SendOtpDataTable $dataTable)
    {
        $products = Product::select(
            'product_title',
            'id',
        )
            ->where('is_active', 1)
            ->get();
        return $dataTable->render('sendotp::index', compact('products'));
    }
}
