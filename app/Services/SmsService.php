<?php

namespace App\Services;

use App\Models\SmsList;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SmsService
{

    public function sendByTitle(string $title, string $mobile, array $data = []): bool
    {
        try {
            $cacheKey = 'sms_template_' . md5($title);

            $template = Cache::remember(
                $cacheKey,
                now()->addHours(6),
                fn() => SmsList::where('title', $title)
                    ->where('is_active', 1)
                    ->latest('id')
                    ->first()
            );

            if (!$template) {
                Log::error("SMS template not found: {$title}");
                return false;
            }

            $message = $this->parseTemplate($template->message, $data);

            $response = Http::timeout(10)->get(
                'http://m.onlinebusinessbazaar.in/sendsms.jsp',
                [
                    'user'     => config('services.sms.obb.username'),
                    'password' => config('services.sms.obb.password'),
                    'senderid' => config('services.sms.obb.sender_id'),
                    'mobiles'  => $mobile,
                    'sms'      => $message,
                ]
            );

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('SMS sending failed', [
                'title'  => $title,
                'mobile' => $mobile,
                'error'  => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function sendOtp(string $mobile, string $otp): bool
    {
        return $this->sendByTitle('OTP Message', $mobile, [
            'OTP' => $otp,
        ]);
    }

    public function sendWebinarPaymentSuccess(
        string $mobile,
        string $name,
        string $invoiceNo
    ): bool {
        return $this->sendByTitle('Webinar Payment Successful', $mobile, [
            'NAME'   => $name,
            'INV_NO' => $invoiceNo,
        ]);
    }

    private function parseTemplate(string $message, array $data): string
    {
        foreach ($data as $key => $value) {
            $message = str_replace('{{' . $key . '}}', $value, $message);
        }
        return $message;
    }

    public function sendPaymentSuccess($transaction)
    {
        $slug = $this->getSuccessSlug($transaction->product_id);
        $this->sendTemplate($slug, $transaction);
    }

    public function sendPaymentFailed($transaction)
    {
        $slug = $this->getFailSlug($transaction->product_id);
        $this->sendTemplate($slug, $transaction);
    }

    private function sendTemplate($title, $transaction)
    {
        $template = SmsList::where('sms_slug', $title)
            ->where('is_active', 1)
            ->orderByDesc('rec_date')
            ->first();
        Log::info("template $title", [$template]);
        if (!$template) return;

        sendSingleSMS(
            $transaction->mobile_no,
            $template->message
        );
    }

    private function getSuccessSlug($product_id)
    {
        return match ((int)$product_id) {
            config('constant.WEIGHT_LOSS_PROGRAM_ID') => 'weight-loss-program-payment-successful',
            config('constant.WEIGHT_LOSS_WEBINAR_ID') => 'weight-loss-webinar-payment-successful',
            config('constant.WEIGHT_LOSS_OFFER_ID') => 'weight-loss-offer-payment-successful',
            config('constant.ULTIMATE_PROGRAM_ID') => 'ultimate-program-payment-successful',
            config('constant.CUSTOMIZE_PROGRAM_ID') => 'customize-program-payment-successful',
            config('constant.WEIGHT_LOSS_WEBINAR_OFFER_ID') => 'weight-loss-webinar-offer-payment-successful',
            config('constant.EXPERT_CONSULTATION_OFFER_ID') => 'expert-consultation-payment-successful',
            config('constant.MEMBERSHIP_PLAN_OFFER_ID') => 'membership-plan-payment-successful',
            config('constant.ASSOCIATE_PARTNER_PROGRAM_OFFER_ID') => 'associate-partner-program-payment-successful',
            config('constant.ADVANCE_PLAN_OFFER_ID') => 'advance-plan-payment-successful',
            config('constant.ONBOARD_UPI_PAYMENT_OFFER_ID') => 'onboard-upi-payment-successful',
            config('constant.EXPERT_CONSULTATION_PLAN_ID') => 'expert-consultation-plan-payment-successful',
            config('constant.HEALTH_COACH_WEBINAR_PRODUCT_ID') => 'health-coach-webinar-payment-successful',
            default => 'fitone-payment-successful',
        };
    }
    private function getFailSlug($product_id)
    {
        return match ((int)$product_id) {
            config('constant.WEIGHT_LOSS_PROGRAM_ID') => 'weight-loss-program-payment-failed',
            config('constant.WEIGHT_LOSS_WEBINAR_ID') => 'weight-loss-webinar-payment-failed',
            config('constant.WEIGHT_LOSS_OFFER_ID') => 'weight-loss-offer-payment-failed',
            config('constant.ULTIMATE_PROGRAM_ID') => 'ultimate-program-payment-failed',
            config('constant.CUSTOMIZE_PROGRAM_ID') => 'customize-program-payment-failed',
            config('constant.WEIGHT_LOSS_WEBINAR_OFFER_ID') => 'weight-loss-webinar-offer-payment-failed',
            config('constant.EXPERT_CONSULTATION_OFFER_ID') => 'expert-consultation-payment-failed',
            config('constant.MEMBERSHIP_PLAN_OFFER_ID') => 'membership-plan-payment-failed',
            config('constant.ASSOCIATE_PARTNER_PROGRAM_OFFER_ID') => 'associate-partner-program-payment-failed',
            config('constant.ADVANCE_PLAN_OFFER_ID') => 'advance-plan-payment-failed',
            config('constant.ONBOARD_UPI_PAYMENT_OFFER_ID') => 'onboard-upi-payment-failed',
            config('constant.EXPERT_CONSULTATION_PLAN_ID') => 'expert-consultation-plan-payment-failed',
            config('constant.HEALTH_COACH_WEBINAR_PRODUCT_ID') => 'health-coach-webinar-payment-failed',
            default => 'fitone-payment-failed',
        };
    }
}
