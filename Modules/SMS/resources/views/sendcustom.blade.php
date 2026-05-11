
@extends('layouts.manage')
@section('title', 'Send Custom Sms')

@push('css-links')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
    <h3>Send Custom Sms</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Send Custom Sms</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card">
                    <form method="post" class="send-custom-form" action="">
                        @csrf
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xxl-12 col-md-12 col-sm-12 button-group-mb-sm">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button class="btn btn-outline-dark" type="button">Self Apply</button>
                                        <button class="btn btn-outline-dark" type="button">Loan Agent</button>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label for=""><strong>Target Customer</strong></label>
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexRadioDefault1" type="radio" name="flexRadioDefault">
                                        <label class="form-check-label" for="flexRadioDefault1">Test SMS</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexRadioDefault2" type="radio" name="flexRadioDefault" checked="">
                                        <label class="form-check-label" for="flexRadioDefault2">Process Step 4 - Membership / Plan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexRadioDefault2" type="radio" name="flexRadioDefault" checked="">
                                        <label class="form-check-label" for="flexRadioDefault2">Process Step 5 - User Verification</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="descriptions">Message</label>
                                    <textarea name="description" id="descriptions" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-outline-success">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-src')
@endpush
@push('script-tag')
@endpush
