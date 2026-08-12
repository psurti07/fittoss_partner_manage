@extends('layouts.manage')
@section('title', 'Statistics')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Weight Loss Webinar Statistics</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Statistics</li>
@endsection

@section('content')
<div class="row">
    <h4 class="text-center mb-3">Today's Statistics</h4>
    <div class="col-lg-3 col-md-3 col-12">
        <a href="{{ route('manage.weight-loss-webinar.leads',['filter' => 'today']) }}" data-bs-original-title="" title="">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div>
                            <h4>{{ $leads }}</h4>
                            <span class="f-light">Total Leads</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-12">
        <a href="{{ route('manage.weight-loss-webinar.customers',['filter' => 'today']) }}" data-bs-original-title="" title="">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div>
                            <h4>{{ $customers }}</h4>
                            <span class="f-light">Total Customers</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-12">
        <a href="{{ route('manage.sendotps',['filter' => 'today','product_id' => config('constant.WEIGHT_LOSS_WEBINAR_ID')]) }}" data-bs-original-title="" title="">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div>
                            <h4>{{ $otps }}</h4>
                            <span class="f-light">Total OTPs</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-12">
        <a href="javascript:;" data-bs-original-title="" title="">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div>
                            <h4>{{ $amount }}</h4>
                            <span class="f-light">Total Amount</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <hr>
</div>
@endsection

@push('script-tag')
@endpush
