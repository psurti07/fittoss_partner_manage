<?php

namespace Modules\OfferUser\Http\Controllers;

use App\DataTables\AdvancePlanCustomerDataTable;
use App\DataTables\AdvancePlanLeadDataTable;
use App\DataTables\AssociatePartnerCustomerDataTable;
use App\DataTables\AssociatePartnerLeadDataTable;
use App\DataTables\ExpertConsultCustomerDataTable;
use App\DataTables\ExpertConsultLeadDataTable;
use App\DataTables\MemberShipCustomerDataTable;
use App\DataTables\MemberShipLeadDataTable;
use App\DataTables\OnboardUPICustomerDataTable;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ExpertConsultationController extends Controller
{

    public function leads(ExpertConsultLeadDataTable $dataTable)
    {
        return $dataTable->render('offeruser::expert-consultation.leads');
    }

    public function customers(ExpertConsultCustomerDataTable $dataTable)
    {
        return $dataTable->render('offeruser::expert-consultation.customers');
    }


    public function membershipLeads(MemberShipLeadDataTable $dataTable)
    {
        return $dataTable->render('offeruser::membership-plan.leads');
    }

    public function membershipCustomers(MemberShipCustomerDataTable $dataTable)
    {
        return $dataTable->render('offeruser::membership-plan.customers');
    }    

    public function associatePartnerLeads(AssociatePartnerLeadDataTable $dataTable)
    {
        return $dataTable->render('offeruser::associate-partner-program.leads');
    }
    public function associatePartnerCustomers(AssociatePartnerCustomerDataTable $dataTable)
    {
        return $dataTable->render('offeruser::associate-partner-program.customers');
    }    

    // Advance plan 
    public function advancePlanLeads(AdvancePlanLeadDataTable $dataTable)
    {
        return $dataTable->render('offeruser::advance-plan.leads');
    }
    public function advancePlanCustomers(AdvancePlanCustomerDataTable $dataTable)
    {
        return $dataTable->render('offeruser::advance-plan.customers');
    }

    // Onboard upi payment
    public function onboardUPICustomers(OnboardUPICustomerDataTable $dataTable)
    {
        return $dataTable->render('offeruser::onboard-upi-payment.customers');
    }

}
