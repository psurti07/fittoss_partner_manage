@if($userData)
<div class="row g-3">
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="mobile" class="fw-bold me-2 mb-0">Product:</label>
        <span id="mobile">{{ $userData->product->product_title ?? '-' }}</span>
    </div>
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="mobile" class="fw-bold me-2 mb-0">Mobile:</label>
        <span id="mobile">{{ $userData->mobile_no ?? '-' }}</span>
    </div>
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="date" class="fw-bold me-2 mb-0">Date:</label>
        <span id="date">{{ date('d-m-Y h:i:s',strtotime($userData->created_at)) ?? '-' }}</span>
    </div>
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="fullname" class="fw-bold me-2 mb-0">Fullname:</label>
        <span id="fullname">
            @if($userData->first_name || $userData->last_name)
            {{ $userData->first_name ?? '-' }} {{ $userData->last_name ?? '-' }}
            @else
            -
            @endif
        </span>
    </div>
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="email" class="fw-bold me-2 mb-0">Email ID:</label>
        <span id="email">{{ $userData->email ?? '-' }}</span>
    </div>
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="fullname" class="fw-bold me-2 mb-0">Source:</label>
        @if($userData->is_user == 0)
        <span id="fullname" class="text-warning">Data as a Company Lead.</span>
        @else
        <span id="fullname" class="text-success">Registred as a customer.</span>
        @endif
    </div>
    <div class="col-12 mt-3">
        @if($userData->is_user == 0)
            @php
            if ($userData->product_id == config('constant.WEIGHT_LOSS_OFFER_ID')) {
                $routeName = route('manage.weight-loss-offer.leads');
            } elseif ($userData->product_id == config('constant.ULTIMATE_PROGRAM_ID')) {
                $routeName = route('manage.ultimate-program.leads');
            } elseif ($userData->product_id == config('constant.CUSTOMIZE_PROGRAM_ID')) {
                $routeName = route('manage.customize-program.leads');
            } elseif ($userData->product_id == config('constant.FITONE_OFFER_ID')) {
                $routeName = route('manage.fitone.leads');
            } elseif ($userData->product_id == config('constant.EXPERT_CONSULTATION_OFFER_ID')) {
                $routeName = route('manage.expert.consultation.leads');
            } elseif ($userData->product_id == config('constant.ADVANCE_PLAN_OFFER_ID')) {
                $routeName = route('manage.advance-plan.leads');
            } elseif ($userData->product_id == config('constant.ASSOCIATE_PARTNER_PROGRAM_OFFER_ID')) {
                $routeName = route('manage.associate-partner-program.leads');
            } elseif ($userData->product_id == config('constant.MEMBERSHIP_PLAN_OFFER_ID')) {
                $routeName = route('manage.membership-plan.leads');
            } elseif ($userData->product_id == config('constant.ONBOARD_UPI_PAYMENT_OFFER_ID')) {
                $routeName = route('manage.onboard-upi-payment.leads');
            } elseif ($userData->product_id == config('constant.WEIGHT_LOSS_PROGRAM_ID')) {
                $routeName = route('manage.weight-loss-program.leads');
            } elseif ($userData->product_id == config('constant.HEALTH_COACH_WEBINAR_PRODUCT_ID')) {
                $routeName = route('manage.health-coach-webinar.leads');
            } elseif ($userData->product_id == config('constant.WEIGHT_LOSS_WEBINAR_OFFER_ID')) {
                $routeName = route('manage.weight-loss-webinar-offer.leads');
            } elseif ($userData->product_id == config('constant.CHILD_NUTRITION_OFFER_ID')) {
                $routeName = route('manage.child-nutrition-offer.leads');
            } elseif ($userData->product_id == config('constant.BODYFAT_ANALYSIS_WORKSHOP_ID')) {
                $routeName = route('manage.bodyfat-analysis-workshop.leads');
            }else{
                $routeName = route('manage.weight-loss-program.leads');
            }             
            @endphp
            <a href="{{ $routeName }}">
                <button type="submit" id="submit" class="btn btn-outline-primary">More Details</button>
            </a>
        @else
            @php
                if ($userData->product_id == config('constant.WEIGHT_LOSS_PROGRAM_ID')) {
                    $routeName = route('manage.weight-loss-program.customers.details',$userData->id);
                } elseif ($userData->product_id == config('constant.WEIGHT_LOSS_WEBINAR_ID')) {
                    $routeName = route('manage.weight-loss-webinar.customers.details',$userData->id);
                } elseif ($userData->product_id == config('constant.BODYFAT_ANALYSIS_WORKSHOP_ID')) {
                    $routeName = route('manage.bodyfat-analysis-workshop.customers.details',$userData->id);
                } else{
                    $routeName = route('manage.customers.details',$userData->id);
                }             
            @endphp
            <a href="{{ $routeName }}">
                <button type="submit" id="submit" class="btn btn-outline-primary">More Details</button>
            </a>
        @endif
    </div>
</div>
@else
<div class="card-body p-0">
    <p class="text-center text-danger">No data available.</p>
</div>
@endif
