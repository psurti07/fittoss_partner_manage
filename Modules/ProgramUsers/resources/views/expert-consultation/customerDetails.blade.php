@extends('layouts.manage')
@section('title', 'Customers Details')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<style>
    .swal-title {
        font-weight: 100 !important;
        font-size: 20px !important;
    }

</style>
@endpush

@section('breadcrumb-title')
<h3>Expert Consultation - Customer Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item active">Customers Details</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        @if($customer->is_active == 0)
        <div class="col-md-12 col-xs-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <p><strong>Customer account is not activated.</strong> You can activate user account from action panel.</p>
            </div>
        </div>
        @endif
        <div class="col-md-12 col-xs-12">
            <ul class="nav nav-pills nav-success" id="pills-warning-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-warning-customerInfo-tab" data-bs-toggle="pill" href="#pills-warning-customerInfo" role="tab" aria-controls="pills-warning-customerInfo" aria-selected="true">
                        <i class="icofont icofont-business-man-alt-1"></i>Customer Info
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-warning-referral-tab" data-bs-toggle="pill" href="#pills-warning-referral" role="tab" aria-controls="pills-warning-referral" aria-selected="true">
                        <i class="icofont icofont-share"></i>&nbsp;Referral Customer List
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-warning-actions-tab" data-bs-toggle="pill" href="#pills-warning-actions" role="tab" aria-controls="pills-warning-actions" aria-selected="true">
                        <i class="icofont icofont-gear"></i>Actions
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="ver-pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-warning-customerInfo" role="tabpanel" aria-labelledby="pills-warning-customerInfo-tab">
                            <form action="{{ route('manage.expert-consultation.customers.update') }}" method="post" class="customer-update-form" id="customer-update-form">
                                <input type="hidden" name="userid" value="{{ $customer->id }}">
                                <div class="row mb-2">
                                    <div class="col-md-12 d-flex justify-content-between">
                                        <h6 class="fw-normal">Registration on: <b>{{ date('d-m-Y H:i', strtotime($customer->created_at)) }}</b></h6>
                                        <h6 class="fw-normal">Referal Code: <b>{{ $customer->refcode }}</b></h6>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-8">
                                        <div class="row mb-2">
                                            <div class="form-group col-md-6">
                                                <label for="first_name">First Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $customer->first_name }}">
                                                @component('components.ajax-error',['field'=>'first_name'])@endcomponent
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name">Last Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $customer->last_name }}">
                                                @component('components.ajax-error',['field'=>'last_name'])@endcomponent
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="form-group col-md-6">
                                                <label for="mobile">Mobile<span class="text-danger">*</span></label>
                                                <input type="tel" disabled inputmode="numeric" class="numeric-input form-control" maxlength="10" minlength="10" id="mobile" name="mobile" value="{{ $customer->mobile_no }}">
                                                @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">Email<span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}">
                                                @component('components.ajax-error',['field'=>'email'])@endcomponent
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row mb-2">
                                            <div class="form-group col-md-12">
                                                <label for="city">City<span class="text-danger">*</span></label>
                                                <input type="text" class="numeric-input form-control" id="city" readonly name="city" value="{{ $customer->city }}">
                                                @component('components.ajax-error',['field'=>'city'])@endcomponent
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <h5>Personal Details</h5>
                                </div>

                                <div class="row mb-2">
                                    {{-- gender --}}
                                    <div class="form-group col-md-4">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="" disabled>Select Gender</option>
                                            <option value="1" {{ $customer->personalDetails?->gender == 1 ? 'selected' :'' }}>Male</option>
                                            <option value="2" {{ $customer->personalDetails?->gender == 2 ? 'selected' :'' }}>Female</option>
                                            <option value="3" {{ $customer->personalDetails?->gender == 3 ? 'selected' :'' }}>Other</option>
                                        </select>
                                        @component('components.ajax-error', ['field' => 'gender'])
                                        @endcomponent
                                    </div>

                                    {{-- age --}}
                                    <div class="form-group col-md-4">
                                        <label for="age">Age</label>
                                        <input type="number" class="form-control" name="age" id="age" value="{{ optional($customer->personalDetails)->age }}" max="{{ date('Y-m-d') }}">
                                        @component('components.ajax-error', ['field' => 'age'])
                                        @endcomponent
                                    </div>

                                    {{-- Health Issues  --}}
                                    <div class="form-group col-md-4">
                                        <label for="is_medical">Health Issues</label>
                                        <select name="is_medical" id="is_medical" class="form-select">
                                            <option value="" disabled selected>Select Health Issues</option>
                                            <option value="1" {{ $customer->personalDetails?->is_medical == 1 ? 'selected' :'' }}>Yes</option>
                                            <option value="2" {{ $customer->personalDetails?->is_medical == 2 ? 'selected' :'' }}>No</option>
                                            <option value="3" {{ $customer->personalDetails?->is_medical == 3 ? 'selected' :'' }}>Prefer not to say</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    {{-- height --}}
                                    <div class="form-group col-md-4">
                                        <label for="goal">Goal</label>
                                        <input type="text" class="form-control" name="goal" id="goal" value="{{ optional($customer->personalDetails)->goal }}">
                                        @component('components.ajax-error', ['field' => 'goal'])
                                        @endcomponent
                                    </div>

                                    {{-- weight --}}
                                    <div class="form-group col-md-4">
                                        <label for="challenge">Challenge</label>
                                        <input type="text" class="form-control" name="challenge" id="challenge" value="{{ optional($customer->personalDetails)->challenge }}">
                                        @component('components.ajax-error', ['field' => 'challenge'])
                                        @endcomponent
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="medical">Medical Issues</label>
                                        <input type="text" class="form-control" name="medical" id="medical" value="{{ optional($customer->personalDetails)->medical }}">
                                        @component('components.ajax-error', ['field' => 'medical'])
                                        @endcomponent
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="preferred_datetime">Request Date Time</label>
                                        <input type="datetime" class="form-control" name="preferred_datetime" id="preferred_datetime" value="{{ optional($customer->personalDetails)->preferred_datetime }}">
                                        @component('components.ajax-error', ['field' => 'preferred_datetime'])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-outline-warning customersBtn" id="customersBtn" name="customersBtn">Save</button>
                                </div>

                            </form>
                        </div>

                        <div class="tab-pane fade" id="pills-warning-referral" role="tabpanel" aria-labelledby="pills-warning-referral-tab">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-border referral-list-table" id="referral-list-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Fullname</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($referralUsers as $user)
                                            <tr>
                                                <td>{{ date('d-m-Y H:i:s') }}</td>
                                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                <td>{{ $user->mobile_no }}</td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-warning-actions" role="tabpanel" aria-labelledby="pills-warning-actions-tab">
                            <form class="row g-3 needs-validation custom-input update-password-form" id="update-password-form" novalidate="" method="post" action="{{ route('manage.expert-consultation.customers.update.password') }}">
                                <input type="hidden" value="{{ $customer->id }}" name="userid">
                                <div class="col-md-4">
                                    <label class="form-label" for="new_password">New Password</label>
                                    <input type="password" class="form-control " id="new_password" name="new_password" required="" autocomplete="new-password">
                                    @component('components.ajax-error',['field'=>'new_password'])@endcomponent
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="retype_password">Retype Password</label>
                                    <input type="password" class="form-control" id="retype_password" name="retype_password" required="" autocomplete="retype-password">
                                    @component('components.ajax-error',['field'=>'retype_password'])@endcomponent
                                </div>
                                <div class="col-md-2">
                                    <label for="">&nbsp;</label>
                                    <h4 id="passwordtext" class=""></h4>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" onclick="return generatepassword();" class="mt-4 btn btn-outline-light active txt-dark" name="generateBtn">Generate</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-outline-warning" name="changePswdBtn" id="changePswdBtn">Change Password</button>
                                </div>
                            </form>
                            <div class="row text-center m-t-40 g-3">
                                <hr />
                                @if($customer->is_active == 1)
                                <div class="col-md-6 text-lg-end">
                                    <button class="btn btn-outline-warning accBtn" id="deactive-btn" onclick="deactivate({{ $customer->id }},0)">DEACTIVATE CUSTOMER ACCOUNT</button>
                                </div>
                                <div class="col-md-6 text-lg-start">
                                    <button class="btn btn-outline-danger" id="delete-btn" onclick="destroy({{ $customer->id }})">DELETE CUSTOMER</button>
                                </div>
                                @else
                                <div class="col-md-6 text-center">
                                    <button class="btn btn-outline-success accBtn" id="activate-btn" onclick="deactivate({{ $customer->id }},1)">ACTIVATE CUSTOMER ACCOUNT</button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clickCountsModals"></div>
@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
@endpush

@push('script-tag')
<script>
    $(".referral-list-table").DataTable({});
    $(".plan-table").DataTable({});

    $(".customer-update-form").submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var data = new FormData(this);
            $.ajax({
                url: $(this).attr("action")
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , type: 'POST'
                , data: data
                , processData: false
                , contentType: false
                , beforeSend: function() {
                    $('#customersBtn').html('<span class="spinner-border spinner-border-sm"></span> Save');
                    $('#customersBtn').attr('disabled', true);
                }
                , success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 2);
                    } else {
                        toastr.error(result.message);
                        $('#customersBtn').html('Save');
                        $('#customersBtn').attr('disabled', false);
                    }
                }
                , error: function(error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors
                        , errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#customersBtn').html('Save');
                    $('#customersBtn').attr('disabled', false);
                }
            });
        }
    })

    function generatepassword() {
        newpass = Math.floor(100000 + Math.random() * 900000);
        document.getElementById('new_password').value = newpass;
        document.getElementById('retype_password').value = newpass;
        $('#passwordtext').html(newpass);
    }

    $('.update-password-form').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var data = new FormData(this);
            $.ajax({
                url: $(this).attr("action")
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , type: 'POST'
                , data: data
                , processData: false
                , contentType: false
                , beforeSend: function() {
                    $('#changePswdBtn').html('<span class="spinner-border spinner-border-sm"></span> Change Password ');
                    $('#changePswdBtn').attr('disabled', true);
                }
                , success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $("#new_password").val('');
                        $("#retype_password").val('');
                        $('#changePswdBtn').html('Change Password ');
                        $('#changePswdBtn').attr('disabled', false);
                    } else {
                        toastr.error(result.message);
                        $('#changePswdBtn').html('Change Password ');
                        $('#changePswdBtn').attr('disabled', false);
                    }
                }
                , error: function(error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors
                        , errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#changePswdBtn').html('Change Password ');
                    $('#changePswdBtn').attr('disabled', false);
                }
            });
        }
    });

    function deactivate(userid, status) {
        var msg = 'You want to deactivate this account.'
        var txtx = 'DEACTIVATE CUSTOMER ACCOUNT';
        if (status == 1) {
            msg = 'You want to activate this account.';
            txtx = 'ACTIVATE CUSTOMER ACCOUNT';
        }
        swal({
            title: "Are you sure?"
            , text: `${msg}`
            , icon: "warning"
            , buttons: true
            , dangerMode: true
            , buttons: ["No", "Yes"]
        , }).then((performYes) => {
            if (performYes) {
                $.ajax({
                    url: `{{ route('manage.expert-consultation.customers.deactivate.account') }}`
                    , type: `POST`
                    , data: JSON.stringify({
                        userid: userid
                        , status: status
                    })
                    , contentType: "application/json"
                    , headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , beforeSend: function() {
                        $('#accBtn').html(`<span class="spinner-border spinner-border-sm"></span> ${txtx} `);
                        $('#accBtn').attr('disabled', true);
                    }
                    , success: function(result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            window.location.reload();
                        } else {
                            toastr.error(result.message);
                        }
                    }
                })
            }
        });
    }

    function destroy(userid) {
        swal({
            text: "You don't need any more of this account"
            , title: "Are you sure?"
            , icon: "warning"
            , buttons: true
            , dangerMode: true
            , buttons: ["No", "Yes"]
        , }).then((performYes) => {
            if (performYes) {
                $.ajax({
                    url: `{{ route('manage.expert-consultation.customers.delete.account') }}`
                    , type: `POST`
                    , data: JSON.stringify({
                        userid: userid
                    })
                    , contentType: "application/json"
                    , headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , beforeSend: function() {
                        $('#accBtn').html(`<span class="spinner-border spinner-border-sm"></span> DELETE CUSTOMER `);
                        $('#accBtn').attr('disabled', true);
                    }
                    , success: function(result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            window.location.href = `{{ route('manage.expert-consultation.customers') }}`;
                        } else {
                            toastr.error(result.message);
                        }
                    }
                })
            }
        });
    }

</script>
@endpush
