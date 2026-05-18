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
<h3>Partner Details ({{ $company->company_name }})</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
<li class="breadcrumb-item"><a href="{{ route('manage.partner.index') }}">Partners</a></li>
<li class="breadcrumb-item active">Partner Details</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        @if ($company->is_active == 0)
        <div class="col-md-12 col-xs-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <p><strong>Partner account is not activated.</strong> You can activate user account from
                    action panel.</p>
            </div>
        </div>
        @endif
        <div class="d-flex justify-content-end gap-2">
            @if ($company->is_active == 1)
            <button class="btn btn-outline-warning accBtn" id="deactive-btn" onclick="deactivate({{ $company->id }},0)">DEACTIVATE PARTNER ACCOUNT</button>
            <button class="btn btn-outline-danger" id="delete-btn" onclick="destroy({{ $company->id }})">DELETE PARTNER</button>
            @else
            <button class="btn btn-outline-success accBtn" id="activate-btn" onclick="deactivate({{ $company->id }},1)">ACTIVATE PARTNER ACCOUNT</button>
            @endif
        </div>
        <div class="col-md-2 col-xs-12">

            <ul class="nav flex-column nav-pills nav-success" id="ver-pills-tab" role="tablist" aria-orientation="vertical">
                <li class="nav-item">
                    <a class="nav-link active" id="ver-pills-companyInfo-tab" data-bs-toggle="pill" href="#ver-pills-companyInfo" role="tab" aria-controls="ver-pills-companyInfo" aria-selected="true">
                        <i class="icofont icofont-bank-alt"></i>Company Info
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ver-pills-ownerInfo-tab" data-bs-toggle="pill" href="#ver-pills-ownerInfo" role="tab" aria-controls="ver-pills-ownerInfo" aria-selected="true">
                        <i class="icofont icofont-business-man-alt-1"></i>Owner Info
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ver-pills-staff-tab" data-bs-toggle="pill" href="#ver-pills-staff" role="tab" aria-controls="ver-pills-staff" aria-selected="true">
                        <i class="icofont icofont-users-social"></i>Staff
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ver-pills-socialInfo-tab" data-bs-toggle="pill" href="#ver-pills-socialInfo" role="tab" aria-controls="ver-pills-socialInfo" aria-selected="true">
                        <i class="icofont icofont-ui-social-link"></i>Social Info
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-10 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="ver-pills-tabContent">

                        <div class="tab-pane fade show active" id="ver-pills-companyInfo" role="tabpanel" aria-labelledby="ver-pills-companyInfo-tab">
                            <form action="{{ route('manage.partner.companyinfo.update') }}" method="post" id="company-update-form">
                                <input type="hidden" name="company_id" value="{{ $company->id }}">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <h6 class="fw-normal">Company Code: <b>{{ $company->company_code }}</b></h6>
                                        <h6 class="fw-normal">Company URL: https://fittoss.com/{{ $company->company_code }}</h6>
                                    </div>
                                    <hr />
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label for="company_name">Company Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_name" id="company_name" value="{{ $company->company_name }}" placeholder="Company Name" />
                                        @component('components.ajax-error', ['field' => 'company_name'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_mobile_no">Company Mobile<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control numeric-input" name="company_mobile_no" maxlength="10" minlength="10" id="company_mobile_no" value="{{ $company->company_mobile_no }}" placeholder="Company Mobile" />
                                        @component('components.ajax-error', ['field' => 'company_mobile_no'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label for="project_name">Project Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="project_name" id="project_name" value="{{ $company->project_name }}" placeholder="Project Name" />
                                        @component('components.ajax-error', ['field' => 'project_name'])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label for="register_date">Registration Date</label>
                                        <input type="date" class="form-control" name="register_date" id="register_date" value="{{ $company->register_date }}" />
                                        @component('components.ajax-error', ['field' => 'register_date'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_live_date">Website Live</label>
                                        <input type="date" class="form-control" name="company_live_date" id="company_live_date" value="{{ $company->company_live_date }}" placeholder="Website Live" />
                                        @component('components.ajax-error', ['field' => 'company_live_date'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label for="website_url">Company Website<span class="text-danger">*</span></label>
                                        <input type="url" class="form-control" name="website_url" id="website_url" value="{{ $company->website_url }}" placeholder="Company Website URL" />
                                        @component('components.ajax-error', ['field' => 'website_url'])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label for="company_email">Company Email<span class="text-danger">*</span></label>
                                        <input type="company_email" class="form-control" name="company_email" id="company_email" value="{{ $company->company_email }}" placeholder="Email" autocomplete="off" />
                                        @component('components.ajax-error', ['field' => 'company_email'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_gst_no">Company GST No</label>
                                        <input type="text" class="form-control" name="company_gst_no" id="company_gst_no" value="{{ $company->company_gst_no }}" placeholder="GST No" />
                                        @component('components.ajax-error', ['field' => 'company_gst_no'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_fssai">Company FSSAI</label>
                                        <input type="text" class="form-control" name="company_fssai" id="company_fssai" value="{{ $company->company_fssai }}" placeholder="FSSAI" />
                                        @component('components.ajax-error', ['field' => 'company_fssai'])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label for="royalty">Royalty(%)</label>
                                        <input type="text" class="form-control" name="royalty" id="royalty" value="{{ $company->royalty }}" placeholder="Royalty" />
                                        @component('components.ajax-error', ['field' => 'royalty'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_type">Company Type<span class="text-danger">*</span></label>
                                        <select class="form-select" id="company_type" name="company_type">
                                            <option disabled>Select Type</option>
                                            @foreach(Modules\Partner\App\Models\Company::COMPANY_TYPES as $key => $value)
                                            <option value="{{ $key }}" {{ $company->company_type == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @component('components.ajax-error', ['field' => 'company_type'])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label for="pincode">Pincode<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control numeric-input" name="pincode" id="pincode" value="{{ $company->pincode }}" placeholder="Pincode" maxlength="6" minlength="6" />
                                        @component('components.ajax-error',['field'=>'pincode'])@endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city">City<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="city" id="city" value="{{ $company->city }}" placeholder="City" />
                                        @component('components.ajax-error',['field'=>'city'])@endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label for="state">State<span class="text-danger">*</span></label>
                                        <select class="form-select" name="state" id="state">
                                            <option value="">Select State</option>
                                            {!! getStateOption($company->state) !!}
                                        </select>
                                        @component('components.ajax-error',['field'=>'state'])@endcomponent
                                    </div>
                                </div>
                                <!-- <div class="col-md-4">
                                        <label>Company Status<span class="text-danger">*</span></label>
                                        <div class="d-flex d-flex gap-4">
                                            <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="company_status" id="company_active" value="1" {{ old('company_status', $company->is_active ?? 1) == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="company_active">
                                                            Active
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="company_status" id="company_inactive" value="0" {{ ($company->is_active == 0) ? "checked" : "" }}>
                                                        <label class="form-check-label" for="company_inactive">
                                                            Inactive
                                                        </label>
                                                    </div>
                                            </div>
                                            @component('components.ajax-error', ['field' => 'is_active'])
                                            @endcomponent
                                        </div> -->
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label for="company_address">Company Address<span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="4" name="company_address" id="company_address">{{ $company->company_address }}</textarea>
                                        @component('components.ajax-error', ['field' => 'company_address'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-4">
                                        <label for="descriptions">Company Descriptions</label>
                                        <textarea class="form-control" rows="4" name="descriptions" id="descriptions">{{ $company->descriptions }}</textarea>
                                        @component('components.ajax-error', ['field' => 'descriptions'])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label for="company_logo">Logo (White)</label>
                                        <input type="file" class="form-control" id="company_logo" name="company_logo">
                                        @component('components.ajax-error', ['field' => 'company_logo'])@endcomponent
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Allowed file types : png</span>
                                            <span class="text-muted">Max size : 1MB</span>
                                            <span class="text-muted">Dimensions : 220x60 pixels (for better resolution)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="{{ $company->logo_url ?? "" }}" width="120px" id="logopreview" class="mt-3">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_color_logo">Logo (Color)</label>
                                        <input type="file" class="form-control" id="company_color_logo" name="company_color_logo">
                                        @component('components.ajax-error', ['field' => 'company_color_logo'])@endcomponent
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Allowed file types : png</span>
                                            <span class="text-muted">Max size : 1MB</span>
                                            <span class="text-muted">Dimensions : 220x60 pixels (for better resolution)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="{{ $company->color_logo_url ?? "" }}" width="120px" id="logopreview_color" class="mt-3">
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label for="company_icon">Icon</label>
                                        <input type="file" class="form-control" id="company_icon" name="company_icon">
                                        @component('components.ajax-error', ['field' => 'company_icon'])@endcomponent
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Allowed file types : png</span>
                                            <span class="text-muted">Max size : 500KB</span>
                                            <span class="text-muted">Dimensions : 80x80 pixels (for better resolution)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="{{ $company->icon_url ?? "" }}" width="120px" id="iconPreview" class="mt-3">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 text-end">
                                    <button type="submit" class="btn btn-outline-warning customersBtn" id="companyBtn" name="customersBtn">Save</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="ver-pills-ownerInfo" role="tabpanel" aria-labelledby="ver-pills-ownerInfo-tab">
                            <form action="{{ route('manage.partner.personalinfo.update') }}" method="post" id="partner-update-personal-form">
                                <input type="hidden" name="company_id" value="{{ $company->id }}">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="owner_name">Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="owner_name" id="owner_name" value="{{ $company->owner_name }}" placeholder="Name" />
                                        @component('components.ajax-error', ['field' => 'owner_name'])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="owner_mobile_no">Mobile<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control numeric-input" name="owner_mobile_no" maxlength="10" minlength="10" id="owner_mobile_no" value="{{ $company->owner_mobile_no }}" placeholder="Mobile" />
                                        @component('components.ajax-error', ['field' => 'owner_mobile_no'])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="owner_email">Email<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="owner_email" id="owner_email" value="{{ $company->owner_email }}" placeholder="Email" />
                                        @component('components.ajax-error', ['field' => 'owner_email'])
                                        @endcomponent
                                    </div>
                                </div>
                                <!-- <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label>Status<span class="text-danger">*</span></label>
                                        <div class="d-flex d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_active" id="active" value="1" {{ old('is_active', $company->is_active ?? 1) == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="active">
                                                    Active
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0" {{ ($company->is_active == 0) ? "checked" : "" }}>
                                                <label class="form-check-label" for="inactive">
                                                    Inactive
                                                </label>
                                            </div>
                                        </div>
                                        @component('components.ajax-error', ['field' => 'is_active'])
                                        @endcomponent
                                    </div>
                                </div> 
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                        @component('components.ajax-error', ['field' => 'image'])@endcomponent
                                    </div>
                                    <div class="form-group col-md-4">
                                        <img src="{{ $company->image_url ?? "" }}" width="120px" id="imgpreview" class="mt-3">
                                    </div>
                                </div>-->
                                <div class="col-md-12 mt-3 text-start">
                                    <button type="submit" class="btn btn-outline-warning customersBtn" id="customersBtn" name="customersBtn">Save</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="ver-pills-staff" role="tabpanel" aria-labelledby="ver-pills-staff-tab">
                            <p>Staff lists here</p>
                        </div>

                        <div class="tab-pane fade" id="ver-pills-socialInfo" role="tabpanel" aria-labelledby="ver-pills-socialInfo-tab">
                            <form action="{{ route('manage.partner.socialinfo.update') }}" method="post" id="social-update-form">
                                <input type="hidden" name="company_id" value="{{ $company->id }}">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="facebook_url">Facebook URL</label>
                                        <input type="text" class="form-control" name="facebook_url" id="facebook_url" value="{{ $company->facebook_url }}" />
                                        @component('components.ajax-error', ['field' => 'facebook_url'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-6">
                                        <label for="instagram_url">Instagram URL</label>
                                        <input type="text" class="form-control" name="instagram_url" id="instagram_url" value="{{ $company->instagram_url }}" />
                                        @component('components.ajax-error', ['field' => 'instagram_url'])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="twitter_url">X(Twitter) URL</label>
                                        <input type="text" class="form-control" name="twitter_url" id="twitter_url" value="{{ $company->twitter_url }}" />
                                        @component('components.ajax-error', ['field' => 'twitter_url'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-6">
                                        <label for="linkedin_url">Linkedin URL</label>
                                        <input type="text" class="form-control" name="linkedin_url" id="linkedin_url" value="{{ $company->linkedin_url }}" />
                                        @component('components.ajax-error', ['field' => 'linkedin_url'])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="pinterest_url">Pinterest URL</label>
                                        <input type="text" class="form-control" name="pinterest_url" id="pinterest_url" value="{{ $company->pinterest_url }}" />
                                        @component('components.ajax-error', ['field' => 'pinterest_url'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-6">
                                        <label for="youtube_url">Youtube URL</label>
                                        <input type="text" class="form-control" name="youtube_url" id="youtube_url" value="{{ $company->youtube_url }}" />
                                        @component('components.ajax-error', ['field' => 'youtube_url'])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-12 mt-3 text-end">
                                        <button type="submit" class="btn btn-outline-warning customersBtn" id="companyBtn" name="customersBtn">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- <div class="tab-pane fade" id="ver-pills-actions" role="tabpanel" aria-labelledby="ver-pills-actions-tab">
                            <form class="row g-3 needs-validation custom-input" id="update-password-form" novalidate="" method="post" action="{{ route('manage.partner.update.password') }}">
                                <input type="hidden" value="{{ $company->id }}" name="company_id">
                                <div class="col-md-4">
                                    <label class="form-label" for="new_password">New Password</label>
                                    <input type="password" class="form-control " id="new_password" name="new_password" required="" autocomplete="new-password">
                                    @component('components.ajax-error', ['field' => 'new_password'])
                                    @endcomponent
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="retype_password">Retype Password</label>
                                    <input type="password" class="form-control" id="retype_password" name="retype_password" required="" autocomplete="retype-password">
                                    @component('components.ajax-error', ['field' => 'retype_password'])
                                    @endcomponent
                                </div>
                                <div class="col-md-2" style="margin-top:45px">
                                    <span id="passwordtext"></span>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="return generatepassword();" class="mt-4 btn btn-outline-light active txt-dark" name="generateBtn">Generate</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-outline-warning" name="changePswdBtn">Change Password</button>
                                </div>
                            </form>
                            <div class="row text-center m-t-40 g-3">
                                @if ($company->is_active == 1)
                                <div class="col-md-6 text-lg-end">
                                    <button class="btn btn-outline-warning accBtn" id="deactive-btn" onclick="deactivate({{ $company->id }},0)">DEACTIVATE PARTNER ACCOUNT</button>
                                </div>
                                <div class="col-md-6 text-lg-start">
                                    <button class="btn btn-outline-danger" id="delete-btn" onclick="destroy({{ $company->id }})">DELETE PARTNER</button>
                                </div>
                                @else
                                <div class="col-md-6 text-center">
                                    <button class="btn btn-outline-success accBtn" id="activate-btn" onclick="deactivate({{ $company->id }},1)">ACTIVATE PARTNER ACCOUNT</button>
                                </div>
                                @endif
                            </div>
                        </div> -->
                    </div>
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
    document.addEventListener('DOMContentLoaded', function() {

        // const imageInput = document.getElementById('image');
        // const preview = document.getElementById('imgpreview');

        // imageInput.addEventListener('change', function() {

        //     const file = this.files[0];

        //     if (!file) return;

        //     // ✅ Validate file type
        //     const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        //     if (!allowedTypes.includes(file.type)) {
        //         alert('Only PNG images allowed.');
        //         this.value = '';
        //         preview.style.display = 'none';
        //         return;
        //     }

        //     // ✅ Validate size (2MB)
        //     if (file.size > 2 * 1024 * 1024) {
        //         alert('Image must be less than 2MB.');
        //         this.value = '';
        //         preview.style.display = 'none';
        //         return;
        //     }

        //     // ✅ Show preview
        //     const reader = new FileReader();

        //     reader.onload = function(e) {
        //         preview.src = e.target.result;
        //         preview.style.display = 'block';
        //     };

        //     reader.readAsDataURL(file);
        // });

        const logoInput = document.getElementById('company_logo');
        const logopreview = document.getElementById('logopreview');
        const colorLogoInput = document.getElementById('company_color_logo');
        const colorLogoPreview = document.getElementById('logopreview_color');
        const iconInput = document.getElementById('company_icon');
        const iconPreview = document.getElementById('iconPreview');

        logoInput.addEventListener('change', function() {

            const file = this.files[0];

            if (!file) return;

            // ✅ Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

            if (!allowedTypes.includes(file.type)) {
                alert('Only PNG images allowed.');
                this.value = '';
                logopreview.style.display = 'none';
                return;
            }

            // ✅ Validate size (1MB)
            if (file.size > 1 * 1024 * 1024) {
                alert('Logo must be less than 1MB.');
                this.value = '';
                logopreview.style.display = 'none';
                return;
            }

            // ✅ Show preview
            const reader = new FileReader();

            reader.onload = function(e) {
                logopreview.src = e.target.result;
                logopreview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        });

        colorLogoInput.addEventListener('change', function() {

            const file = this.files[0];

            if (!file) return;

            // ✅ Validate file type
            const allowedTypes = ['image/png'];

            if (!allowedTypes.includes(file.type)) {
                alert('Only PNG images allowed.');
                this.value = '';
                colorLogoPreview.style.display = 'none';
                return;
            }

            // ✅ Validate size (1MB)
            if (file.size > 1 * 1024 * 1024) {
                alert('Logo must be less than 1MB.');
                this.value = '';
                colorLogoPreview.style.display = 'none';
                return;
            }

            // ✅ Show preview
            const reader = new FileReader();

            reader.onload = function(e) {
                colorLogoPreview.src = e.target.result;
                colorLogoPreview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        });

        iconInput.addEventListener('change', function() {

            const file = this.files[0];

            if (!file) return;

            // ✅ Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

            if (!allowedTypes.includes(file.type)) {
                alert('Only PNG images allowed.');
                this.value = '';
                iconPreview.style.display = 'none';
                return;
            }

            // ✅ Validate size (500KB)
            if (file.size > 500 * 1024) {
                alert('Icon must be less than 500KB.');
                this.value = '';
                iconPreview.style.display = 'none';
                return;
            }

            // ✅ Show preview
            const reader = new FileReader();

            reader.onload = function(e) {
                iconPreview.src = e.target.result;
                iconPreview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        });

    });


    $('#partner-update-personal-form').submit(function() {
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
    });

    $('#company-update-form').submit(function() {
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
                    $('#companyBtn').html(
                        '<span class="spinner-border spinner-border-sm"></span> Save');
                    $('#companyBtn').attr('disabled', true);
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
                        $('#companyBtn').html('Save');
                        $('#companyBtn').attr('disabled', false);
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
                    $('#companyBtn').html('Save');
                    $('#companyBtn').attr('disabled', false);
                }
            });
        }
    });

    $('#social-update-form').submit(function() {
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
                    $('#companyBtn').html(
                        '<span class="spinner-border spinner-border-sm"></span> Save');
                    $('#companyBtn').attr('disabled', true);
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
                        $('#companyBtn').html('Save');
                        $('#companyBtn').attr('disabled', false);
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
                    $('#companyBtn').html('Save');
                    $('#companyBtn').attr('disabled', false);
                }
            });
        }
    });

    function generatepassword() {
        newpass = Math.floor(100000 + Math.random() * 900000);
        document.getElementById('new_password').value = newpass;
        document.getElementById('retype_password').value = newpass;
        $('#passwordtext').html(newpass);
    }

    $('#update-password-form').submit(function(event) {
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
                , success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $("#new_password").val('');
                        $("#retype_password").val('');
                    } else {
                        toastr.error(result.message);
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
                }
            });
        }
    });

    function deactivate(company_id, status) {
        var msg = 'You want to deactivate this account.'
        var txtx = 'DEACTIVATE PARTNER ACCOUNT';
        if (status == 1) {
            msg = 'You want to activate this account.';
            txtx = 'ACTIVATE PARTNER ACCOUNT';
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
                    url: `{{ route('manage.partner.account.deactivate') }}`
                    , type: `POST`
                    , data: JSON.stringify({
                        company_id: company_id
                        , status: status
                    })
                    , contentType: "application/json"
                    , headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , beforeSend: function() {
                        $('#accBtn').html(
                            `<span class="spinner-border spinner-border-sm"></span> ${txtx} `);
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

    function destroy(company_id) {
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
                    url: `{{ route('manage.partner.account.delete') }}`
                    , type: `POST`
                    , data: JSON.stringify({
                        company_id: company_id
                    })
                    , contentType: "application/json"
                    , headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , beforeSend: function() {
                        $('#accBtn').html(
                            `<span class="spinner-border spinner-border-sm"></span> DELETE STAFF `
                        );
                        $('#accBtn').attr('disabled', true);
                    }
                    , success: function(result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            window.location.href = `{{ route('manage.partner.index') }}`;
                        } else {
                            toastr.error(result.message);
                        }
                    }
                })
            }
        });
    }

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
                        // Populate City and State fields
                        $('#city').val(response.district);
                        $('#state').val(response.state);
                    } else {
                        alert(response.message);
                        $(".pincode-msg").text('');
                        $('#city').val('');
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
