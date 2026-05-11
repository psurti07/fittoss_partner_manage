@extends('layouts.manage')
@section('title', 'SMS Settings')

@push('css-links')
@endpush
@push('style-css')
<style>
    .custom-rounded {
        border-radius: 10px;
    }
</style>
@endpush

@section('breadcrumb-title')
<h3>SMS Settings</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Site Options</li>
    <li class="breadcrumb-item active">SMS Settings</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">SMS Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        {{-- Common Sender ID Form --}}
                        <form method="post" action="{{ route('manage.sms.settings.update') }}" class="sms-setting-form">
                            @csrf
                            <input type="hidden" name="option_key" value="{{ App\Constants\OptionKeys::COMMON_SENDER_ID }}">
                            <div class="form-group">
                                <label for="option_value">Common Sender ID<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input class="form-control" name="option_value" type="text" value="{{ $options->where('option_key', App\Constants\OptionKeys::COMMON_SENDER_ID)->value('option_value') ?? '' }}">
                                    <button class="btn btn-outline-secondary" type="submit">Update</button>
                                </div>
                                <span class="text-danger error-value"></span>
                                @component('components.ajax-error',['field'=>'option_value'])@endcomponent
                            </div>
                        </form>
                        {{-- Offer Sender ID Form --}}
                        <form method="post" action="{{ route('manage.sms.settings.update') }}" class="sms-setting-form">
                            @csrf
                            <input type="hidden" name="option_key" value="{{ App\Constants\OptionKeys::OFFER_PAGE_SENDER_ID}}">
                            <div class="form-group mt-3">
                                <label for="option_value">Offer Sender ID<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input class="form-control" name="option_value" type="text" value="{{ $options->where('option_key', App\Constants\OptionKeys::OFFER_PAGE_SENDER_ID)->value('option_value') ?? '' }}">
                                    <button class="btn btn-outline-secondary" type="submit">Update</button>
                                </div>
                                <span class="text-danger error-value"></span>
                                @component('components.ajax-error',['field'=>'option_value'])@endcomponent
                            </div>
                        </form>
                        {{-- Offer Remarketing Sender ID Form --}}
                        <form method="post" action="{{ route('manage.sms.settings.update') }}" class="sms-setting-form">
                            @csrf
                            <input type="hidden" name="option_key" value="{{ App\Constants\OptionKeys::OFFER_MARKETING_SENDER_ID}}">
                            <div class="form-group mt-3">
                                <label for="option_value">Offer Remarketing Sender ID<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input class="form-control" name="option_value" type="text" value="{{ $options->where('option_key', App\Constants\OptionKeys::OFFER_MARKETING_SENDER_ID)->value('option_value') ?? '' }}">
                                    <button class="btn btn-outline-secondary" type="submit">Update</button>
                                </div>
                                <span class="text-danger error-value"></span>
                                @component('components.ajax-error',['field'=>'option_value'])@endcomponent
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
    document.querySelectorAll('.sms-setting-form').forEach(form => {

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const button = form.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            const errorBox = form.querySelector('.error-value');

            errorBox.innerHTML = '';

            button.disabled = true;
            button.innerHTML = 'Updating...';

            try {
                const response = await fetch(form.action, {
                    method: "POST"
                    , headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    }
                    , body: new FormData(form)
                });

                const result = await response.json();

                button.disabled = false;
                button.innerHTML = originalText;

                if (result.type === "SUCCESS") {
                    toastr.success(result.message);
                    //location.reload();
                } else {
                    toastr.error(result.message);
                }

            } catch (err) {
                button.disabled = false;
                button.innerHTML = originalText;
                errorBox.innerHTML = "Something went wrong";
            }
        });

    });

</script>
@endpush
