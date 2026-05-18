<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\SiteOption;

class InvoiceService
{
    public function createInvoice($transaction, $paymentDetail)
    {
        $invoiceNo = SiteOption::where('option_key', 'newinvoiceno')->first();
        $igst = 0;
        $cgst = 0;
        $sgst = 0;
        if (strtolower($transaction->state) === 'gujarat') {
            $cgst = round($transaction->amount * 0.09, 2);
            $sgst = round($transaction->amount * 0.09, 2);
        } else {
            $igst = round($transaction->amount * 0.18, 2);
        }

        $invoice = Invoice::create([
            'company_id' => $transaction->company_id,
            'userid' => $transaction->id,
            'user_type' => 2,
            'inv_prefix' => 'INV_',
            'inv_number' => $invoiceNo->option_value,
            'inv_price' => $transaction->amount,
            'inv_grandtotal' => $transaction->grand_total,
            'inv_cgst'       => $cgst,
            'inv_sgst'       => $sgst,
            'inv_igst'       => $igst,
            'order_id'       => $paymentDetail->order_id,
            'payment_id'     => $paymentDetail->payment_id ?? NULL,
            'inv_date' => now(),
            'updated_at' => now(),
            'created_at' => now(),
        ]);
        // $invoice->refresh();
        $invoiceNo->increment('option_value');
        return $invoice;
    }
}
