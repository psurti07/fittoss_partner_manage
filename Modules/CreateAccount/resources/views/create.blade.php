@extends('layouts.manage')
@section('title', 'Create An Account')

@push('css-links')
@endpush
@push('style-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .swal-title {
        font-size: 20px
    }

</style>
@endpush

@section('breadcrumb-title')
<h3>Create An Account</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">General</li>
<li class="breadcrumb-item active">Create An Account</li>
@endsection

@section('content')
<div class="container-fluid">
    <form method="post" action="{{ route('manage.customers.store') }}" class="create-account-form" id="create-account-form">
        <div class="row g-3">
            <div class="col-sm-12 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-b-0">Personal Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="form-group col-md-6">
                                <label for="product_id">Product</label>
                                <select name="product_id" id="product_id" class="form-select">
                                    <option value="" disabled selected>Select Product</option>
                                    @foreach($products as $key => $product)
                                    <option value={{ $product->id }}>{{ $product->productname }}</option>
                                    @endforeach
                                </select>
                                @component('components.ajax-error', ['field' => 'product_id'])
                                @endcomponent
                            </div>

                            {{-- rec date --}}
                            <div class="form-group col-md-6">
                                <label for="created_at">Registration Date<span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="created_at" id="created_at" value="{{ old('created_at') ?? now()->format('Y-m-d\TH:i:s') }}" max="{{ now()->format('Y-m-d\TH:i:s') }}">
                                @component('components.ajax-error', ['field' => 'created_at'])
                                @endcomponent
                            </div>

                            {{-- first name --}}
                            <div class="form-group col-md-6">
                                <label for="first_name">First Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}">
                                @component('components.ajax-error', ['field' => 'first_name'])
                                @endcomponent
                            </div>
                            {{-- last name --}}
                            <div class="form-group col-md-6">
                                <label for="last_name">Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}">
                                @component('components.ajax-error', ['field' => 'last_name'])
                                @endcomponent
                            </div>
                            {{-- mobile --}}
                            <div class="form-group col-md-6">
                                <label for="mobile_no">Mobile<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="{{ old('mobile_no') }}" maxlength="10" minlength="10">
                                @component('components.ajax-error', ['field' => 'mobile_no'])
                                @endcomponent
                            </div>
                            {{-- email --}}
                            <div class="form-group col-md-6">
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                @component('components.ajax-error', ['field' => 'email'])
                                @endcomponent
                            </div>
                            {{-- pincode --}}
                            <div class="form-group col-md-6">
                                <label for="pincode">Pincode<span class="text-danger">*</span></label>
                                <input type="text" class="form-control numeric-input" name="pincode" id="pincode" value="{{ old('pincode') }}" maxlength="6" minlength="6">
                                @component('components.ajax-error', ['field' => 'pincode'])
                                @endcomponent
                            </div>
                            {{-- state --}}
                            <div class="form-group col-md-6">
                                <label for="state">State<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="state" id="state" readonly>
                                @component('components.ajax-error', ['field' => 'state'])
                                @endcomponent
                            </div>
                            {{-- city --}}
                            <div class="form-group col-md-6">
                                <label for="city">City<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}" readonly>
                                @component('components.ajax-error', ['field' => 'city'])
                                @endcomponent
                            </div>
                            <span class="pincode-msg text-info"></span>
                            {{-- is user --}}
                            <input type="hidden" class="form-control" name="is_user" value="1">
                            {{-- is_agree --}}
                            <input type="hidden" class="form-control" name="is_agree" value="1">
                            {{-- is_dnd --}}
                            <input type="hidden" class="form-control" name="is_dnd" value="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-b-0">Health Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- gender --}}
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-select">
                                    <option value="">Select Gender</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Other</option>
                                </select>
                                @component('components.ajax-error', ['field' => 'gender'])
                                @endcomponent
                            </div>

                            {{-- age --}}
                            <div class="form-group col-md-6">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" name="age" id="age" value="{{ old('age') }}">
                                @component('components.ajax-error', ['field' => 'age'])
                                @endcomponent
                            </div>

                            {{-- height --}}
                            <div class="form-group col-md-6">
                                <label for="height">Height (cm)</label>
                                <input type="number" class="form-control" name="height" id="height" value="{{ old('height') }}">
                                @component('components.ajax-error', ['field' => 'height'])
                                @endcomponent
                            </div>

                            {{-- weight --}}
                            <div class="form-group col-md-6">
                                <label for="weight">Weight (kg)</label>
                                <input type="number" class="form-control" name="weight" id="weight" value="{{ old('weight') }}">
                                @component('components.ajax-error', ['field' => 'weight'])
                                @endcomponent
                            </div>

                            {{-- Active Rate  --}}
                            <div class="form-group col-md-6">
                                <label for="active_rate">Active Rate</label>
                                <select name="active_rate" id="active_rate" class="form-select">
                                    <option value="" disabled selected>Select Active Rate</option>
                                    <option value="0">Little or no activity</option>
                                    <option value="1">Lightly active</option>
                                    <option value="2">Moderately active</option>
                                    <option value="3">Very active</option>
                                </select>
                            </div>

                            {{-- medical issue --}}
                            <div class="form-group col-md-6">
                                <label for="medical_issue">Medical Issue</label>
                                <select name="medical_issue[]" id="medical_issue" multiple class="form-select">
                                    @foreach($diseases as $disease)
                                    <option value="{{ $disease->name }}">
                                        {{ $disease->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @component('components.ajax-error', ['field' => 'medical_issue'])@endcomponent
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="m-b-0">Payment Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- Amount --}}
                            <div class="form-group col-md-12">
                                <label for="amount">Amount<span class="text-danger">*</span></label>
                                <input type="text" class="form-control mb-2" name="amount" id="amount">
                                <em><strong>Note:</strong> 18% GST amount added on amount.</em>
                                @component('components.ajax-error',['field'=>'amount'])@endcomponent
                            </div>

                            <div class="form-group col-md-12">
                                <label for="paymentid">Payment Id<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="paymentid" id="paymentid" value="cash_{{ random_code(13) }}">
                                @component('components.ajax-error',['field'=>'paymentid'])@endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="text-end mt-2 mb-4">
                <button type="submit" class="btn btn-primary" id="create-account-btn">Create
                    Account</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script-src')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
   $(document).ready(function() {
     $('#medical_issue').select2({
        placeholder: "Select Diseases",
        width: '100%',
     });
   });
</script>
<script>
    $('#pincode').on('input', function() {
        var pincode = $(this).val();

        // Only make request if pincode is of 6 digits
        if (pincode.length === 6) {
            $('#loader').show(); // Show loader
            $.ajax({
                url: `{{ route('manage.postal.details') }}`, // Route to the Laravel controller
                type: 'POST'
                , data: {
                    pincode: pincode
                }
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pass CSRF token
                }
                , beforeSend: function(xhr) {
                    $(".pincode-msg").text('we are fetching cities and state..'); // Example: Show a loading indicator
                }
                , success: function(response) {
                    $('#loader').hide(); // Hide loader
                    if (response.status === 'success') {
                        $(".pincode-msg").text('');
                        // Populate District and State fields
                        $('#city').val(response.district);
                        $('#state').val(response.state);
                    } else {
                        alert(response.message);
                        $(".pincode-msg").text('');
                        $('#district').val('');
                        $('#state').val('');
                    }
                }
                , error: function() {
                    $('#loader').hide(); // Hide loader on error
                    $(".pincode-msg").text('');
                    alert('An error occurred while fetching the details.');
                }
            });
        } else {
            // Clear the fields if pincode length is not 6 digits
            $('#city').val('');
            $('#state').val('');
        }
    });
    $(".create-account-form").submit(function(event) {
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
                    $('#create-account-btn').html(
                        '<span class="spinner-border spinner-border-sm"></span> Create Account');
                    $('#create-account-btn').attr('disabled', true);
                }
                , success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        window.location.reload();
                    } else {
                        toastr.error(result.message);
                        $('#create-account-btn').html('Create Account');
                        $('#create-account-btn').attr('disabled', false);
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
                    $('#create-account-btn').html('Create Account');
                    $('#create-account-btn').attr('disabled', false);
                }
            });
        }
    })

</script>
@endpush
@push('script-tag')
@endpush
