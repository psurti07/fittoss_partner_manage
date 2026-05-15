@extends('layouts.manage')
@section('title', 'Partners')

@push('css-links')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Add Partner</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Partners</li>
<li class="breadcrumb-item active">Add Partner</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">

        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Partner Account</h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">Owner Details</h6>

                    <form action="{{ route('manage.partner.store') }}" method="post" class="partner-create-form" id="partner-create-form">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="owner_name">Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="owner_name" id="owner_name" value="" placeholder="Name" />
                                @component('components.ajax-error', ['field' => 'owner_name'])
                                @endcomponent
                            </div>
                            <div class="col-md-4">
                                <label for="owner_email">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="owner_email" id="owner_email" value="" placeholder="john@gmail.com" />
                                @component('components.ajax-error', ['field' => 'owner_email'])
                                @endcomponent
                            </div>
                            <div class="col-md-4">
                                <label for="owner_mobile_no">Mobile No<span class="text-danger">*</span></label>
                                <input type="tel" class="form-control numeric-input" name="owner_mobile_no" maxlength="10" minlength="10" id="owner_mobile_no" value="" placeholder="6578451237" />
                                @component('components.ajax-error', ['field' => 'owner_mobile_no'])
                                @endcomponent
                            </div>
                        </div>

                        <h6 class="mb-3 mt-3">Company Details</h6>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="company_name">Company Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="company_name" id="company_name" value="" placeholder="Company Name" />
                                @component('components.ajax-error', ['field' => 'company_name'])
                                @endcomponent
                            </div>
                            <div class="col-md-4">
                                <label for="company_mobile_no">Company Mobile<span class="text-danger">*</span></label>
                                <input type="tel" class="form-control numeric-input" name="company_mobile_no" maxlength="10" minlength="10" id="company_mobile_no" value="" placeholder="Company Mobile" />
                                @component('components.ajax-error', ['field' => 'company_mobile_no'])
                                @endcomponent
                            </div>
                            <div class="col-md-4">
                                <label for="project_name">Project Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="project_name" id="project_name" value="" placeholder="Project Name" />
                                @component('components.ajax-error', ['field' => 'project_name'])
                                @endcomponent
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="website_url">Website URL<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="website_url" id="website_url" value="" placeholder="Website URL" />
                                @component('components.ajax-error', ['field' => 'website_url'])
                                @endcomponent
                            </div>
                            <div class="col-md-4">
                                <label for="company_email">Company Email<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="company_email" id="company_email" value="" placeholder="Company Email" />
                                @component('components.ajax-error', ['field' => 'company_email'])
                                @endcomponent
                            </div>
                            <div class="col-md-4">
                                <label for="company_type">Company Type<span class="text-danger">*</span></label>
                                <select class="form-select" id="company_type" name="company_type">
                                    <option disabled>Select Type</option>
                                    @foreach(Modules\Partner\App\Models\Company::COMPANY_TYPES as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @component('components.ajax-error', ['field' => 'company_type'])
                                @endcomponent
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="pincode">Pincode<span class="text-danger">*</span></label>
                                <input type="text" class="form-control numeric-input" name="pincode" id="pincode" value="{{ old('pincode') }}" placeholder="Pincode" maxlength="6" minlength="6" />
                                @component('components.ajax-error',['field'=>'pincode'])@endcomponent
                            </div>
                            <div class="col-md-4">
                                <label for="city">City<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}" placeholder="City" />
                                @component('components.ajax-error',['field'=>'city'])@endcomponent
                            </div>
                            <div class="col-md-4">
                                <label for="state">State<span class="text-danger">*</span></label>
                                <select class="form-select" name="state" id="state">
                                    <option value="">Select State</option>
                                    {!! getStateOption(old('state') ?? '') !!}
                                </select>
                                @component('components.ajax-error',['field'=>'state'])@endcomponent
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="company_gst_no">Company GST No</label>
                                <input type="text" class="form-control" name="company_gst_no" id="company_gst_no" value="" placeholder="Company GST No" />
                                @component('components.ajax-error', ['field' => 'company_gst_no'])
                                @endcomponent
                            </div>
                            <div class="col-md-4">
                                <label for="company_fssai">Company FSSAI</label>
                                <input type="text" class="form-control" name="company_fssai" id="company_fssai" value="" placeholder="FSSAI" />
                                @component('components.ajax-error', ['field' => 'company_fssai'])
                                @endcomponent
                            </div>
                            <div class="col-md-4">
                                <label for="company_address">Address</label>
                                <textarea id="company_address" class="form-control" name="company_address" rows="3" placeholder="13A, ABC Apartments XYZ Park Extension New Delhi, Delhi 110016"></textarea>
                                @component('components.ajax-error', ['field' => 'company_address'])
                                @endcomponent
                            </div>
                        </div>

                        <div class="col-md-12 mt-3 text-end">
                            <button type="submit" class="btn btn-outline-warning customersBtn" id="customersBtn" name="customersBtn">Save</button>
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
    // document.addEventListener('DOMContentLoaded', function() {

    //     const imageInput = document.getElementById('image');
    //     const preview = document.getElementById('imgpreview');

    //     imageInput.addEventListener('change', function() {

    //         const file = this.files[0];

    //         if (!file) return;

    //         // ✅ Validate file type
    //         const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

    //         if (!allowedTypes.includes(file.type)) {
    //             alert('Only JPG, PNG, WEBP images allowed.');
    //             this.value = '';
    //             preview.style.display = 'none';
    //             return;
    //         }

    //         // ✅ Validate size (2MB)
    //         if (file.size > 2 * 1024 * 1024) {
    //             alert('Image must be less than 2MB.');
    //             this.value = '';
    //             preview.style.display = 'none';
    //             return;
    //         }

    //         // ✅ Show preview
    //         const reader = new FileReader();

    //         reader.onload = function(e) {
    //             preview.src = e.target.result;
    //             preview.style.display = 'block';
    //         };

    //         reader.readAsDataURL(file);
    //     });

    //     const logoInput = document.getElementById('company_logo');
    //     const logopreview = document.getElementById('logopreview');

    //     logoInput.addEventListener('change', function() {

    //         const file = this.files[0];

    //         if (!file) return;

    //         // ✅ Validate file type
    //         const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

    //         if (!allowedTypes.includes(file.type)) {
    //             alert('Only JPG, PNG, WEBP images allowed.');
    //             this.value = '';
    //             logopreview.style.display = 'none';
    //             return;
    //         }

    //         // ✅ Validate size (2MB)
    //         if (file.size > 2 * 1024 * 1024) {
    //             alert('Image must be less than 2MB.');
    //             this.value = '';
    //             logopreview.style.display = 'none';
    //             return;
    //         }

    //         // ✅ Show preview
    //         const reader = new FileReader();

    //         reader.onload = function(e) {
    //             logopreview.src = e.target.result;
    //             logopreview.style.display = 'block';
    //         };

    //         reader.readAsDataURL(file);
    //     });

    // });

    $('.partner-create-form').submit(function() {
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
                        '<span class="spinner-border spinner-border-sm"></span> Save');
                    $('#customersBtn').attr('disabled', true);
                }
                , success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        window.location.href = "{{ route('manage.partner.index') }}";
                        // setTimeout(function() {
                        //     window.location.reload();
                        // }, 2);
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
    });

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

</script>
@endpush
