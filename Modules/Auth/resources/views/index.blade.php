@extends('layouts.auth')
@section('title','Partner')
@push('css-links')
@endpush
@push('style-css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 p-0">
            <div class="login-card login-dark bg-lending-gradient">
                <div>
                    <div class="login-main" style="border: 2px solid #0815420d;">
                        <div class="w-50">
                            <a class="logo text-start" href="javascript:;">
                                <img class="img-login" src="{{asset('assets/images/logo/fittoss-logo.png')}}" alt="{{ env('APP_NAME') }}" width="200" />
                            </a>
                        </div>
                        <form class="theme-form auth-form" action="{{ route('manage.authenticate') }}" method="POST">
                            <h5>Sign in to account</h5>
                            <div class="form-group">
                                <label class="col-form-label">Company Code <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" placeholder="CODE" name="company_code" id="company_code" value="{{ old('company_code') }}" />
                                @component('components.ajax-error',['field'=>'company_code'])@endcomponent
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Email Address <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" placeholder="Enter Email" name="email" id="email" value="{{ old('email') }}" />
                                @component('components.ajax-error',['field'=>'email'])@endcomponent
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Password <span class="text-danger">*</span></label>
                                <input class="form-control" type="password" name="password" placeholder="Enter Password" id="password" />
                                <!-- <div class="show-hide mt-3">
                                    <span class="show"></span>
                                </div> -->
                                 @component('components.ajax-error',['field'=>'password'])@endcomponent
                            </div>
                            <div class="form-group mt-3 mb-0">
                                <button class="btn btn-lg submit-btn w-100" id="signInBtn" class="signInBtn" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-src')
@endpush
@push('script-tag')
<script>
    $('.auth-form').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
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
                beforeSend: function(){
                    $('#signInBtn').html('<span class="spinner-border spinner-border-sm"></span> Sign in');
                    $('#signInBtn').attr('disabled', true);
                },
                success: function(result) {
                    console.log(result, "result");
                    $('#signInBtn').attr("disabled", false);
                    $('#signInBtn').html('Sign in');
                    if (result.type === 'SUCCESS') {
                        window.location.href = result.redirect
                    } else {
                        toastr.error(result.message)
                        $("#password").val('');
                    }
                },
                error: function(error) {
                    $('#signInBtn').attr("disabled", false);
                    $('#signInBtn').html('Sign in');
                    let errors = error.responseJSON.errors,
                        errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                }
            });
        }
    });
</script>
@endpush
