<?php

namespace Modules\OfferUser\Http\Controllers;

use App\DataTables\FitoneCustomerDataTable;
use App\DataTables\FitoneLeadDataTable;
use App\Models\Invoice;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FitoneUserController extends Controller
{

    public function leads(FitoneLeadDataTable $dataTable)
    {
        return $dataTable->render('offeruser::fitone.leads');
    }

    public function customers(FitoneCustomerDataTable $dataTable)
    {
        return $dataTable->render('offeruser::fitone.customers');
    }

    public function downloadPdf($userId)
    {
        $transaction = Customer::findOrFail($userId);
        $invoice = Invoice::with('user')
            ->where('userid', $transaction->id)
            ->where('order_id', $transaction->order_id)
            ->firstOrFail();
        $invoiceData = [
            'invoice' => $invoice,
            'user' => $transaction
        ];

        $pdf = Pdf::loadView('invoice.invoice_pdf', $invoiceData);
        return $pdf->download('invoice-' . $transaction->order_id . '.pdf');
    }

}
