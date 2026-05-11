@extends('layouts.manage')
@section('title', 'Employee Details')

@push('style-css')
<style>
    .swal-title {
        font-weight: 100 !important;
        font-size: 20px !important;
    }

    #passwordtext {
        font-size: 18px;
        font-weight: bold
    }
</style>
@endpush

@section('breadcrumb-title')
<h3>Employee Details</h3>
@endsection

@section('breadcrumb')
<div class="row">
    <div class="col-6">
        <h3>Employee Lists</h3>
    </div>
    <div class="col-6">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('manage.dashboard') }}">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                    </svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('manage.employee.index') }}">Employee Lists</a></li>
            <li class="breadcrumb-item active">Employee Details</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        @if($data->isActive == 0)
        <div class="col-md-12 col-xs-12">
            <div class="alert alert-warning fade show" role="alert">
                <p>Employee account is not activated. You can activate the account from the action panel.</p>
            </div>
        </div>
        @endif
        <div class="col-md-12 col-xs-12">
            <ul class="nav nav-pills nav-success" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="pill" href="#employee-info" role="tab">
                        <i class="icofont icofont-business-man-alt-1"></i>Employee Info
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#employee-kyc" role="tab">
                        <i class="icofont icofont-gear"></i>KYC Documents
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#employee-attendance" role="tab">
                        <i class="icofont icofont-gear"></i>Attendance Report
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#employee-actions" role="tab">
                        <i class="icofont icofont-gear"></i>Actions
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="employee-info" role="tabpanel">
                            <form action="{{ route('manage.employee.update', $data->id) }}" method="post" class="employee-update-form" id="employee-update-form">
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="col-md-12 mb-3">
                                    <h6 class="fw-normal">Registration on: <b>{{ date('d-m-Y H:i', strtotime($data->rec_date)) }}</b></h6>
                                </div>
                                <div class="col-md-12">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="mb-0">Personal Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <label for="name">Employee Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}" placeholder="John Doe">
                                                    @component('components.ajax-error',['field'=>'name'])@endcomponent
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="mobile_no">Mobile<span class="text-danger">*</span></label>
                                                    <input type="tel" class="form-control" id="mobile_no" name="mobile_no" minlength="10" maxlength="10" value="{{ $data->mobile_no }}" placeholder="+91 9876543210">
                                                    @component('components.ajax-error',['field'=>'mobile_no'])@endcomponent
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email">Email<span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ $data->email }}" placeholder="john@doe.com">
                                                    @component('components.ajax-error',['field'=>'email'])@endcomponent
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="dob">DOB</label>
                                                    <input type="date" class="form-control" id="dob" name="dob" value="{{ $data->dob }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="department">Department</label>
                                                    <input type="text" class="form-control" id="department" name="department" value="{{ $data->department }}" placeholder="Sales">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="doj">Date of Joining</label>
                                                    <input type="date" class="form-control" id="doj" name="doj" value="{{ $data->doj }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="resign_date">Resign Date</label>
                                                    <input type="date" class="form-control" id="resign_date" name="resign_date" value="{{ $data->resign_date }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="city">City</label>
                                                    <input type="text" class="form-control" id="city" name="city" value="{{ $data->city }}" placeholder="Surat">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="state">State</label>
                                                    <input type="text" class="form-control" id="state" name="state" value="{{ $data->state }}" placeholder="Gujarat">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Address</label>
                                                    <textarea class="form-control" name="address" id="address" rows="2" placeholder="Home Address">{{ $data->address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">Reference</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <label for="reference_name">Reference Name</label>
                                                        <input type="text" class="form-control" id="reference_name" name="reference_name" value="{{ $data->reference_name }}" placeholder="John Doe">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="reference_mobile">Reference Mobile No.</label>
                                                        <input type="tel" class="form-control" id="reference_mobile" name="reference_mobile" minlength="10" maxlength="10" value="{{ $data->reference_mobile }}" placeholder="+91 9876543210">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="reference_dob">Reference DOB</label>
                                                        <input type="date" class="form-control" id="reference_dob" name="reference_dob" value="{{ $data->reference_dob }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">Office Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <label for="punching_code">Punching Code</label>
                                                        <input type="text" class="form-control" id="punching_code" name="punching_code" value="{{ $data->punching_code ?? random_code_num(6) }}" placeholder="E10001">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="salary">Salary</label>
                                                        <input type="text" class="form-control" id="salary" name="salary" value="{{ $data->salary }}" placeholder="25,000">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label>Remarks</label>
                                                        <textarea class="form-control" name="remarks" id="remarks" rows="2" placeholder="Remarks">{{ $data->remarks }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">Bonus Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <label for="bonus_start_date">Bonus Start Date</label>
                                                        <input type="date" class="form-control" id="bonus_start_date" name="bonus_start_date" value="{{ $data->bonus_start_date }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="bonus_end_date">Bonus End Date</label>
                                                        <input type="date" class="form-control" id="bonus_end_date" name="bonus_end_date" value="{{ $data->bonus_end_date }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="bonus_eligible_date">Bonus Eligible Date</label>
                                                        <input type="date" class="form-control" id="bonus_eligible_date" name="bonus_eligible_date" value="{{ $data->bonus_eligible_date }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">Probation Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <label for="probation_start_date">Probation Start Date</label>
                                                        <input type="date" class="form-control" id="probation_start_date" name="probation_start_date" value="{{ $data->probation_start_date }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="probation_end_date">Probation End Date</label>
                                                        <input type="date" class="form-control" id="probation_end_date" name="probation_end_date" value="{{ $data->probation_end_date }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 text-end">
                                    <button type="submit" class="btn btn-outline-warning" id="employeeSaveBtn">Save</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="employee-kyc" role="tabpanel">
                            <h5 class="mt-4 mb-3">KYC Documents</h5>
                            <div class="row g-3">
                                @php
                                $employeeSiteUrl = 'https://team.indiakarobar.com';
                                $docs = [
                                    'aadhaar_card' => 'Aadhaar Card',
                                    'pan_card' => 'PAN Card',
                                    'passport_photo' => 'Passport Photo',
                                    'cancel_cheque' => 'Cancel Cheque',
                                    'address_proof' => 'Address Proof (Light Bill)',
                                ];
                                $uploadedDocs = 0;
                                @endphp

                                @foreach($docs as $field => $label)
                                @if($data->$field)
                                @php $uploadedDocs++; @endphp
                                <div class="col-md-4 text-center">
                                    <label class="fw-bold d-block mb-2">{{ $label }}</label>
                                    <a href="{{ $employeeSiteUrl . '/' . $data->$field }}" target="_blank">
                                        <img src="{{ $employeeSiteUrl . '/' . $data->$field }}"
                                            class="img-fluid border rounded mb-2"
                                            style="max-height:160px; object-fit:contain;"
                                            alt="{{ $label }}">
                                    </a>
                                    <div>
                                        <a href="{{ $employeeSiteUrl . '/' . $data->$field }}"
                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-outline-danger delete-kyc-btn" data-field="{{ $field }}" data-id="{{ $data->id }}">
                                            Delete
                                        </a>
                                    </div>
                                </div>
                                @endif
                                @endforeach

                                @if($uploadedDocs == 0)
                                <div class="col-md-12 text-center text-muted">
                                    <p>No documents uploaded.</p>
                                </div>
                                @endif
                            </div>

                            @if($uploadedDocs > 0)
                            <div class="text-end mt-3">
                                @if($data->isApproved)
                                <button class="btn btn-warning btn-sm toggle-kyc-btn" data-id="{{ $data->id }}" data-status="1">Mark as Pending</button>
                                @else
                                <button class="btn btn-success btn-sm toggle-kyc-btn" data-id="{{ $data->id }}" data-status="0">Approve KYC</button>
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="employee-attendance" role="tabpanel">
                            <div class="table-responsive mt-3">
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered table-striped" id="attendanceTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Check In</th>
                                                <th>Check Out</th>
                                                <th>Work Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($attendance) > 0)
                                            @foreach($attendance as $key => $att)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($att->rec_date)->format('d-m-Y') }}</td>
                                                <td>{{ $att->check_in ? \Carbon\Carbon::parse($att->check_in)->format('h:i A') : 'N/A' }}</td>
                                                <td>{{ $att->check_out ? \Carbon\Carbon::parse($att->check_out)->format('h:i A') : 'N/A' }}</td>
                                                <td>
                                                    @if($att->work_time)
                                                    {{ \Carbon\Carbon::parse($att->work_time)->format('H:i') }} hrs
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                            </tr>

                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="5" class="text-center">No attendance records found.</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>


                        <div class="tab-pane fade" id="employee-actions" role="tabpanel">
                            <div class="row text-center g-3">
                                @if($data->isActive == 1)
                                <div class="col-md-6 text-lg-end">
                                    <button class="btn btn-outline-warning" onclick="toggleStatus({{ $data->id }})">DEACTIVATE EMPLOYEE ACCOUNT</button>
                                </div>
                                <div class="col-md-6 text-lg-start">
                                    <button class="btn btn-outline-danger" onclick="destroyEmployee({{ $data->id }})">DELETE EMPLOYEE</button>
                                </div>
                                @else
                                <div class="col-md-6 text-center">
                                    <button class="btn btn-outline-success" onclick="toggleStatus({{ $data->id }})">ACTIVATE EMPLOYEE ACCOUNT</button>
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
@endsection

@push('script-tag')
<script>
    $(document).ready(function() {
        $("#mobile_no, #reference_mobile, #salary").on("input", function() {
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    });

    function filePreviewHandler(inputId, previewId) {
        $("#" + inputId).change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#' + previewId).attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            } else {
                $('#' + previewId).attr('src', 'https://docutils.sourceforge.io/sandbox/py-rest-doc/sphinx/style/preview.png');
            }
        });
    }

    $(document).ready(function() {
        filePreviewHandler('aadhaar_card', 'aadhaar-card-preview');
        filePreviewHandler('pan_card', 'pan-card-preview');
        filePreviewHandler('passport_photo', 'passport-photo-preview');
        filePreviewHandler('cancel_cheque', 'cancel-cheque-preview');
        filePreviewHandler('address_proof', 'address-proof-preview');
    });

    // Save Employee
    $(".employee-update-form").submit(function(event) {
        event.preventDefault();
        $('.ajax-error').html('');
        var data = new FormData(this);
        $.ajax({
            url: $(this).attr("action"),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#employeeSaveBtn').html('<span class="spinner-border spinner-border-sm"></span> Save');
                $('#employeeSaveBtn').attr('disabled', true);
            },
            success: function(result) {
                $('#employeeSaveBtn').html('Save').attr('disabled', false);
                if (result.type === 'SUCCESS') {
                    toastr.success(result.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 800);
                } else {
                    toastr.error(result.message);
                }
            },
            error: function(error) {
                $('#employeeSaveBtn').html('Save').attr('disabled', false);
                let errors = error.responseJSON.errors || {};
                $.each(errors, function(key, value) {
                    $('.' + key).html('<strong>' + value[0] + '</strong>');
                });
                toastr.error('Validation error!');
            }
        });
    });

    // Toggle Status
    function toggleStatus(id) {
        $.ajax({
            url: "{{ route('manage.employee.toggleStatus', ':id') }}".replace(':id', id),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                if (result.type === 'SUCCESS') {
                    toastr.success(result.message);
                    window.location.reload();
                } else {
                    toastr.error(result.message);
                }
            }
        });
    }

    // Delete Employee
    function destroyEmployee(id) {
        swal({
            title: "Are you sure?",
            text: "This employee account will be deleted.",
            icon: "warning",
            buttons: ["No", "Yes"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('manage.employee.delete', ':id') }}".replace(':id', id),
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            window.location.href = "{{ route('manage.employee.index') }}";
                        } else {
                            toastr.error(result.message);
                        }
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        $('.toggle-kyc-btn').on('click', function() {
            var employeeId = $(this).data('id');
            var button = $(this);

            $.ajax({
                url: "{{ route('manage.employee.toggleKyc', ':id') }}".replace(':id', employeeId),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                beforeSend: function() {
                    button.attr('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
                },
                success: function(result) {
                    button.attr('disabled', false);

                    if (result.type === 'SUCCESS') {
                        if (button.data('status') == 1) {
                            button.removeClass('btn-warning')
                                .addClass('btn-success')
                                .text('Approve KYC')
                                .data('status', 0);

                            button.prev('span')
                                .removeClass('bg-success')
                                .addClass('bg-warning text-dark')
                                .text('Pending');
                        } else {
                            button.removeClass('btn-success')
                                .addClass('btn-warning')
                                .text('Mark as Pending')
                                .data('status', 1);

                            button.prev('span')
                                .removeClass('bg-warning text-dark')
                                .addClass('bg-success')
                                .text('Approved');
                        }

                        toastr.success(result.message);
                    } else {
                        toastr.error(result.message);
                    }
                },
                error: function(xhr) {
                    button.attr('disabled', false);
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });
    });

    // Delete KYC File
    $(document).on('click', '.delete-kyc-btn', function() {
        var employeeId = $(this).data('id');
        var field = $(this).data('field');
        var button = $(this);

        swal({
            title: "Are you sure?",
            text: "This KYC document will be deleted.",
            icon: "warning",
            buttons: ["No", "Yes"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('manage.employee.deleteKycFile', ':id') }}".replace(':id', employeeId),
                    type: 'POST',
                    data: { field: field },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    beforeSend: function() {
                        button.attr('disabled', true).text('Deleting...');
                    },
                    success: function(res) {
                        button.attr('disabled', false).text('Delete');
                        if(res.type === 'SUCCESS'){
                            toastr.success(res.message);
                            button.closest('.col-md-4').remove();
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function() {
                        button.attr('disabled', false).text('Delete');
                        toastr.error('Something went wrong.');
                    }
                });
            }
        });
    });
</script>
@endpush