@extends('layouts.manage')
@section('title', 'Partner Details')

@push('css-links')
@endpush
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
<h3>Profile Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('manage.dashboard') }}" class="text-decoration-none color-2f2f3b">Dashboard</a></li>
<li class="breadcrumb-item active">Profile Details</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
            <div class="card height-equal">
                <div class="card-body">
                    <form action="{{ route('manage.profile.update') }}" method="post" id="profile-update-form">
                        @csrf
                        <div class="col-12 mt-3">
                            <h6 class="fw-normal">Referal Code: <b>{{ $partner->staff_code }}</b></h6>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label" for="name">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $partner->name }}" placeholder="Name" />
                            @component('components.ajax-error', ['field' => 'name'])
                            @endcomponent
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label" for="mobile_no">Mobile<span class="text-danger">*</span></label>
                            <input type="tel" class="form-control numeric-input" name="mobile_no" maxlength="10" minlength="10" id="mobile_no" value="{{ $partner->mobile_no }}" placeholder="Mobile" />
                            @component('components.ajax-error', ['field' => 'mobile_no'])
                            @endcomponent
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label" for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $partner->email }}" placeholder="Email" />
                            @component('components.ajax-error', ['field' => 'email'])
                            @endcomponent
                        </div>
                        <div class="form-footer mt-3 d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary" id="customersBtn" name="customersBtn">Update</button>
                            <a href="{{ route('manage.changePassword') }}" class="text-primary">Change Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-src')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush

@push('script-tag')
<script>
    $('#profile-update-form').submit(function() {
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
                    $('#customersBtn').html(
                        '<span class="spinner-border spinner-border-sm"></span> Updating...');
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
                        $('#customersBtn').html('Update');
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
                    $('#customersBtn').html('Update');
                    $('#customersBtn').attr('disabled', false);
                }
            });
        }
    });

</script>
@endpush
