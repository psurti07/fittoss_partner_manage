<?php

namespace Modules\CompanyLeads\App\Http\Controllers;

use App\DataTables\CompanyLeadsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyLeadsController extends Controller
{
    public function index(CompanyLeadsDataTable $dataTable)
    {
        return $dataTable->render('companyleads::index');
    }
}
