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
<h3>UAT Numbers</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('manage.dashboard') }}" class="text-decoration-none color-2f2f3b">Dashboard</a></li>
<li class="breadcrumb-item active">UAT Numbers</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
            <div class="card height-equal">
                <div class="card-body">
                    <form action="{{ route('manage.uat-setting.update') }}" method="post" id="number-update-form">
                        @csrf
                        <div class="col-12 mt-3">
                            <label class="form-label" for="payment_numbers">Payment Number (1 Rs payment)<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="payment_numbers" id="payment_numbers"> {{ $numbers->payment_numbers ?? "" }} </textarea>
                            @component('components.ajax-error', ['field' => 'payment_numbers'])@endcomponent
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label" for="remarketing_numbers">Remarketing Numbers<span class="text-danger">*</span></label>
                            <textarea class="form-control numeric-input" name="remarketing_numbers" maxlength="10" minlength="10" id="remarketing_numbers"> {{ $numbers->remarketing_numbers ?? "" }} </textarea>
                            @component('components.ajax-error', ['field' => 'remarketing_numbers'])@endcomponent
                        </div>
                        <div class="form-footer mt-3 d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary" id="updateBtn" name="updateBtn">Update</button>
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
    $('#number-update-form').submit(function() {
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
                    $('#updateBtn').html(
                        '<span class="spinner-border spinner-border-sm"></span> Updating...');
                    $('#updateBtn').attr('disabled', true);
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
                        $('#updateBtn').html('Update');
                        $('#updateBtn').attr('disabled', false);
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
                    $('#updateBtn').html('Update');
                    $('#updateBtn').attr('disabled', false);
                }
            });
        }
    });

</script>
@endpush
