<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class MailService
{
    public function sendPaymentSuccessMail($transaction, ?Invoice $invoice = null)
    {
        try {
            $mailConfig = $this->resolveMailTemplate($transaction->product_id);

            $mailData = [
                'fullname' => trim($transaction->first_name . ' ' . $transaction->last_name),
                'email'    => $transaction->email,
            ];

            $emailContent = view($mailConfig['template'], [
                'name' => $mailData['fullname']
            ])->render();

            // Generate invoice PDF
            if ($invoice) {
                $invoiceData = [
                    'invoice' => $invoice,
                    'user' => $transaction
                ];
                $invoiceHtml = view('invoice.invoice_pdf', $invoiceData)->render();
                $pdf = Pdf::loadHTML($invoiceHtml)->setPaper('A4', 'portrait')->output();
                $base64Pdf = base64_encode($pdf);

                // Prepare attachments
                $attachments = [
                    [
                        'content' => $base64Pdf,
                        'name' => 'Invoice_' . $invoice->inv_prefix . $invoice->inv_number . '.pdf'
                    ]
                ];
            }
            sendBrevoHtmlMail2($mailData, $mailConfig['subject'], $emailContent, $attachments ?? []);
        } catch (\Throwable $e) {
            Log::error('Payment success mail failed', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function resolveMailTemplate($product_id)
    {
        return match ((int)$product_id) {
            config('constant.WEIGHT_LOSS_PROGRAM_ID') => [
                'subject'  => 'Welcome to Fittoss – Your Health Journey Starts Here',
                'template' => 'front.weight-loss-program.emails.payment_success'
            ],
            config('constant.WEIGHT_LOSS_WEBINAR_ID') => [
                'subject'  => 'Your Webinar Slot is Confirmed! 🎉',
                'template' => 'front.weight-loss-webinar.emails.payment_success'
            ],
            config('constant.WEIGHT_LOSS_OFFER_ID') => [
                'subject'  => '🎉 Welcome to Fittoss!',
                'template' => 'front.offers.weight-loss-offer.emails.payment_success'
            ],
            config('constant.ULTIMATE_PROGRAM_ID') => [
                'subject'  => '🎉 Welcome to Fittoss!',
                'template' => 'front.offers.ultimate-program.emails.payment_success'
            ],
            config('constant.CUSTOMIZE_PROGRAM_ID') => [
                'subject'  => '🎉 Welcome to Fittoss!',
                'template' => 'front.offers.customize-program.emails.payment_success'
            ],
            config('constant.WEIGHT_LOSS_WEBINAR_OFFER_ID') => [
                'subject'  => 'Congratulations: Webinar Registration Confirmed ',
                'template' => 'front.offers.weight-loss-webinar-offer.emails.payment_success'
            ],
            config('constant.CHILD_NUTRITION_OFFER_ID') => [
                'subject'  => 'Congratulations: Webinar Registration Confirmed ',
                'template' => 'front.offers.child-nutrition-offer.emails.payment_success'
            ],
            config('constant.EXPERT_CONSULTATION_OFFER_ID') => [
                'subject'  => 'Welcome to Fittoss – Your Health Journey Starts Here',
                'template' => 'front.offers.expert-consultation.emails.payment_success'
            ],
            config('constant.MEMBERSHIP_PLAN_OFFER_ID') => [
                'subject'  => '🎉 Welcome to Fittoss!',
                'template' => 'front.offers.membership-plan.emails.payment_success'
            ],
            config('constant.ASSOCIATE_PARTNER_PROGRAM_OFFER_ID') => [
                'subject'  => 'Your Fittoss Associate Partnership is Confirmed 🎉',
                'template' => 'front.offers.associate-partner-program.emails.payment_success'
            ],
            config('constant.ADVANCE_PLAN_OFFER_ID') => [
                'subject'  => 'Welcome to Fittoss – Advance Plan Confirmed',
                'template' => 'front.offers.advance-plan.emails.payment_success'
            ],
            config('constant.EXPERT_CONSULTATION_PLAN_ID') => [
                'subject'  => 'Welcome to Fittoss – Your Expert Consultation is Confirmed',
                'template' => 'front.masterclass.expert-consultation-plan.emails.payment_success'
            ],
            config('constant.HEALTH_COACH_WEBINAR_PRODUCT_ID') => [
                'subject'  => 'Welcome to Fittoss – Your Expert Consultation is Confirmed',
                'template' => 'front.masterclass.health-coach-webinar.emails.payment_success'
            ],
            default => [
                'subject'  => 'Welcome to Fittoss – Your Health Journey Starts Here',
                'template' => 'front.offers.fitone.emails.payment_success'
            ],
        };
    }
}
