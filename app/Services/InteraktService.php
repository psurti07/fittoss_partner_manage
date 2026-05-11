<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class InteraktService
{
    public function sendMessage($userDetail, $template_name)
    {
        $mobile_no = $userDetail->mobile_no;
        $fullName = $userDetail->first_name . ' ' . $userDetail->last_name;
        $waMobile = $this->normalizeMobile($mobile_no);
        $data = [
            'fullPhoneNumber' => '+91' . $waMobile,
            'callbackData' => 'some text here',
            'type' => 'Template',
            'template' => [
                'name' => $template_name,
                'languageCode' => 'en'
            ]
        ];
        // if (in_array($userDetail->product_id, [
        //     config('constant.FITONE_OFFER_ID'),
        //     config('constant.EXPERT_CONSULTATION_OFFER_ID'),
        //     config('constant.MEMBERSHIP_PLAN_OFFER_ID'),
        //     config('constant.ADVANCE_PLAN_OFFER_ID')
        // ])) {
        //     $data['template']['bodyValues'] = [$fullName];
        // }

        Log::info('Sending Interakt message', ['mobile_no' => $mobile_no, 'payload' => $data]);
        interakt_message($data);
    }

    private function normalizeMobile($mobile)
    {
        $digits = preg_replace('/\D/', '', $mobile);
        return substr($digits, -10);
    }

    public function getInteraktSuccessTemplate($product_id)
    {
        return match ((int)$product_id) {
            config('constant.WEIGHT_LOSS_PROGRAM_ID') => config('constant.WEIGHT_LOSS_PROGRAM_SUCCESS_TEMPLATE_NAME'),
            config('constant.WEIGHT_LOSS_WEBINAR_ID') => config('constant.WEIGHT_LOSS_WEBINAR_SUCCESS_TEMPLATE_NAME'),
            config('constant.WEIGHT_LOSS_OFFER_ID') => config('constant.WEIGHT_LOSS_OFFER_SUCCESS_TEMPLATE_NAME'),
            config('constant.ULTIMATE_PROGRAM_ID') => config('constant.ULTIMATE_PROGRAM_SUCCESS_TEMPLATE_NAME'),
            config('constant.CUSTOMIZE_PROGRAM_ID') => config('constant.CUSTOMIZE_PROGRAM_SUCCESS_TEMPLATE_NAME'),
            config('constant.WEIGHT_LOSS_WEBINAR_OFFER_ID') => config('constant.WEIGHT_LOSS_WEBINAR_OFFER_SUCCESS_TEMPLATE_NAME'),
            config('constant.EXPERT_CONSULTATION_OFFER_ID') => config('constant.EXPERT_CONSULTATION_SUCCESS_TEMPLATE_NAME'),
            config('constant.MEMBERSHIP_PLAN_OFFER_ID') => config('constant.MEMBERSHIP_PLAN_SUCCESS_TEMPLATE_NAME'),
            config('constant.ASSOCIATE_PARTNER_PROGRAM_OFFER_ID') => config('constant.ASSOCIATE_PARTNER_PROGRAM_SUCCESS_TEMPLATE_NAME'),
            config('constant.ADVANCE_PLAN_OFFER_ID') => config('constant.ADVANCE_PLAN_SUCCESS_TEMPLATE_NAME'),
            config('constant.EXPERT_CONSULTATION_PLAN_ID') => config('constant.EXPERT_CONSULTATION_PLAN_SUCCESS_TEMPLATE_NAME'),
            config('constant.HEALTH_COACH_WEBINAR_PRODUCT_ID') => config('constant.HEALTH_COACH_WEBINAR_SUCCESS_TEMPLATE_NAME'),
            default => config('constant.FITONE_SUCCESS_TEMPLATE_NAME'),
        };
    }
    public function getInteraktFailTemplate($product_id)
    {
        return match ((int)$product_id) {
            config('constant.WEIGHT_LOSS_PROGRAM_ID') => config('constant.WEIGHT_LOSS_PROGRAM_FAIL_TEMPLATE_NAME'),
            config('constant.WEIGHT_LOSS_WEBINAR_ID') => config('constant.WEIGHT_LOSS_WEBINAR_FAIL_TEMPLATE_NAME'),
            config('constant.WEIGHT_LOSS_OFFER_ID') => config('constant.WEIGHT_LOSS_OFFER_FAIL_TEMPLATE_NAME'),
            config('constant.ULTIMATE_PROGRAM_ID') => config('constant.ULTIMATE_PROGRAM_FAIL_TEMPLATE_NAME'),
            config('constant.CUSTOMIZE_PROGRAM_ID') => config('constant.CUSTOMIZE_PROGRAM_FAIL_TEMPLATE_NAME'),
            config('constant.WEIGHT_LOSS_WEBINAR_OFFER_ID') => config('constant.WEIGHT_LOSS_WEBINAR_OFFER_FAIL_TEMPLATE_NAME'),
            config('constant.EXPERT_CONSULTATION_OFFER_ID') => config('constant.EXPERT_CONSULTATION_FAIL_TEMPLATE_NAME'),
            config('constant.MEMBERSHIP_PLAN_OFFER_ID') => config('constant.MEMBERSHIP_PLAN_FAIL_TEMPLATE_NAME'),
            config('constant.ASSOCIATE_PARTNER_PROGRAM_OFFER_ID') => config('constant.ASSOCIATE_PARTNER_PROGRAM_FAIL_TEMPLATE_NAME'),
            config('constant.ADVANCE_PLAN_OFFER_ID') => config('constant.ADVANCE_PLAN_FAIL_TEMPLATE_NAME'),
            config('constant.EXPERT_CONSULTATION_PLAN_ID') => config('constant.EXPERT_CONSULTATION_PLAN_FAIL_TEMPLATE_NAME'),
            config('constant.HEALTH_COACH_WEBINAR_PRODUCT_ID') => config('constant.HEALTH_COACH_WEBINAR_FAIL_TEMPLATE_NAME'),
            default => config('constant.FITONE_FAIL_TEMPLATE_NAME'),
        };
    }
}
