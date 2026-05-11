@extends('layouts.manage')
@section('title', config('dashboard.name'))

@push('css-links')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Dashboard</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">{!! config('dashboard.name') !!}</li>
@endsection

@section('content')
<div class="container-fluid">
 
    <div class="row widget-grid">
        <div class="col-xxl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top"> 
                        <h5>Weight Loss Program</h5>
                        <a class="f-light d-flex align-items-center" href="{{ route('manage.weight-loss-program.statistics') }}">View all <i class="f-w-700 icon-arrow-top-right"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-sm-3 g-2">
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">Leads</span>
                                    <h6 class="mt-1 mb-0">{{ $data->get(config('constant.WEIGHT_LOSS_PROGRAM_ID'))->leads ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#customers') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">Customers</span>
                                    <h6 class="mt-1 mb-0">{{ $data->get(config('constant.WEIGHT_LOSS_PROGRAM_ID'))->customers ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#new-order') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">Amount</span>
                                    <h6 class="mt-1 mb-0">{{ $data->get(config('constant.WEIGHT_LOSS_PROGRAM_ID'))->amount ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#24-hour') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">OTPs</span>
                                    <h6 class="mt-1 mb-0">{{ $otps->get(config('constant.WEIGHT_LOSS_PROGRAM_ID'))->total ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row widget-grid">
        <div class="col-xxl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top"> 
                        <h5>Weight Loss Webinar</h5>
                        <a class="f-light d-flex align-items-center" href="{{ route('manage.weight-loss-webinar.statistics') }}">View all <i class="f-w-700 icon-arrow-top-right"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-sm-3 g-2">
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">Leads</span>
                                    <h6 class="mt-1 mb-0">{{ $data->get(config('constant.WEIGHT_LOSS_WEBINAR_ID'))->leads ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#customers') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">Customers</span>
                                    <h6 class="mt-1 mb-0">{{ $data->get(config('constant.WEIGHT_LOSS_WEBINAR_ID'))->customers ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#new-order') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">Amount</span>
                                    <h6 class="mt-1 mb-0">{{ $data->get(config('constant.WEIGHT_LOSS_WEBINAR_ID'))->amount ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#24-hour') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">OTPs</span>
                                    <h6 class="mt-1 mb-0">{{ $otps->get(config('constant.WEIGHT_LOSS_WEBINAR_ID'))->total ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row widget-grid">
        <div class="col-xxl-12 col-md-12 box-col-12">
            <div class="card">
                <div class="card-header card-no-border">
                    <div class="header-top"> 
                        <h5>Body Fat Analysis Workshop</h5>
                        <a class="f-light d-flex align-items-center" href="{{ route('manage.bodyfat-analysis-workshop.statistics') }}">View all <i class="f-w-700 icon-arrow-top-right"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-sm-3 g-2">
                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">Leads</span>
                                    <h6 class="mt-1 mb-0">{{ $data->get(config('constant.BODY_FAT_ANALYSIS_WORKSHOP_ID'))->leads ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#customers') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">Customers</span>
                                    <h6 class="mt-1 mb-0">{{ $data->get(config('constant.BODY_FAT_ANALYSIS_WORKSHOP_ID'))->customers ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#new-order') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">Amount</span>
                                    <h6 class="mt-1 mb-0">{{ $data->get(config('constant.BODY_FAT_ANALYSIS_WORKSHOP_ID'))->amount ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="light-card balance-card">
                                <div class="svg-box">
                                    <svg class="svg-fill">
                                        <use href="{{ asset('assets/svg/icon-sprite.svg#24-hour') }}"></use>
                                    </svg>
                                </div>
                                <div> 
                                    <span class="f-light">OTPs</span>
                                    <h6 class="mt-1 mb-0">{{ $otps->get(config('constant.BODY_FAT_ANALYSIS_WORKSHOP_ID'))->total ?? 0 }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script-src')
<script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script>
@endpush
@push('script-tag')
@endpush
