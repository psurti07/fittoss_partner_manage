@extends('layouts.manage')
@section('title', 'Events')

@push('style-css')
<style>
    .cke_inner {
        border: 1px solid #eee !important;
    }

</style>
@endpush

@section('breadcrumb-title')
<h3>Add Event</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href={{ route('manage.events.index')}}>Events</a></li>
<li class="breadcrumb-item active">Add Event</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('manage.events.store') }}" method="POST" class="mt-2" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6 col-12 form-group">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label>Event Title <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control">
                                        </div>
                                        @component('components.ajax-error',['field'=>'title'])@endcomponent
                                        @error('title')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="description">Event Description</label>
                                        <textarea id="description" name="description" cols="10" rows="5" class="form-control">{{ old('description') }}</textarea>
                                        @component('components.ajax-error', ['field' => 'description'])@endcomponent
                                        @error('description')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        <small id="descCharCount" class="text-muted">0 / 700 characters</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12 form-group">
                                <div class="row g-3">
                                    <div class="col-md-6 col-12 form-group">
                                        <div class="form-group">
                                            <label>Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="amount" id="amount" value="{{ old('amount') }}">
                                            </div>
                                        </div>
                                        @component('components.ajax-error',['field'=>'amount'])@endcomponent
                                        @error('amount')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 form-group">
                                        <div class="form-group">
                                            <label>Offer Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="offer_amount" id="offer_amount" value="{{ old('offer_amount') }}">
                                            </div>
                                        </div>
                                        @component('components.ajax-error',['field'=>'offer_amount'])@endcomponent
                                        @error('offer_amount')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12 form-group">
                                        <label>Coach Name</label>
                                        <div class="input-group">
                                            <input type="text" name="coach_name" id="coach_name" value="{{ old('coach_name') }}" class="form-control">
                                        </div>
                                        @component('components.ajax-error',['field'=>'coach_name'])@endcomponent
                                        @error('coach_name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="date">Date</label>
                                        <input class="form-control" type="date" id="date" value="{{ old('date') ? old('date')->format('Y-m-d') : '' }}" name="date">
                                        @component('components.ajax-error', ['field' => 'date'])@endcomponent
                                        @error('date')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="start_time">Start Time</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') ? old('start_time')->format('H:i') : '' }}">
                                        @component('components.ajax-error', ['field' => 'start_time'])@endcomponent
                                        @error('start_time')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="end_time">End Time</label>
                                        <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') ? old('end_time')->format('H:i') : '' }}">
                                        @component('components.ajax-error', ['field' => 'end_time'])@endcomponent
                                        @error('end_time')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12 form-group">
                                        <label>Language</label>
                                        <div class="input-group">
                                            <select name="language" id="language" class="form-control">
                                                <option selected value="">Select Language</option>
                                                <option {{ (old('language') == "hindi") ? 'selected' : '' }} value="hindi">Hindi</option>
                                                <option {{ (old('language') == "english") ? 'selected' : '' }} value="english">English</option>
                                                <option {{ (old('language') == "gujarati") ? 'selected' : '' }} value="gujarati">Gujarati</option>
                                                <option {{ (old('language') == "hinglish") ? 'selected' : '' }} value="hinglish">Hinglish</option>
                                            </select>
                                        </div>
                                        @component('components.ajax-error',['field'=>'language'])@endcomponent
                                        @error('language')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-12 form-group">
                                        <label>In Offer</label>
                                        <div class="input-group">
                                            <select name="in_offer" id="in_offer" class="form-control">
                                                <option {{ (old('in_offer') == 1) ? 'selected' : '' }} value=1>Yes</option>
                                                <option {{ (old('in_offer') == 0) ? 'selected' : '' }} value=0>No</option>
                                            </select>
                                        </div>
                                        @component('components.ajax-error',['field'=>'in_offer'])@endcomponent
                                        @error('in_offer')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                        @component('components.ajax-error', ['field' => 'image'])@endcomponent
                                        @error('image')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <img src="{{ old('image_url') ?? NULL }}" width="120px" id="imgpreview" class="mt-3">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 d-flex justify-content-end gap-2">
                                <a href="{{ route('manage.events.index') }}" class="btn btn-outline-secondary">Back</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-src')
<script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/editor/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('assets/js/editor/ckeditor/styles.js') }}"></script>
<script src="{{ asset('assets/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
@endpush


@push('script-tag')
@if(Session::has('success'))
<script>
    toastr.success('{{Session::get('success')}}')
</script>
@endif
@if(session('error'))
<script>
    toastr.error('{{Session::get('error')}}')
</script>
@endif

<script>
    document.getElementById('image')?.addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgpreview').src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    });


    document.addEventListener("DOMContentLoaded", function() {

        // ✅ Initialize CKEditor
        if (typeof CKEDITOR !== "undefined") {

            const editor = CKEDITOR.replace('description');

            function getPlainTextLength(editorInstance) {
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = editorInstance.getData();
                return tempDiv.innerText.trim().length;
            }

            editor.on('change', function() {
                const length = getPlainTextLength(editor);
                const counter = document.getElementById('descCharCount');

                if (counter) {
                    counter.textContent = length + " / 700 characters";
                }
            });
        }

        // ✅ Amount numeric only
        const amountInput = document.getElementById("amount");
        if (amountInput) {
            amountInput.addEventListener("input", function() {
                this.value = this.value.replace(/[^0-9]/g, "");
            });
        }

        // ✅ Offer Amount numeric only
        const offerAmountInput = document.getElementById("offer_amount");
        if (offerAmountInput) {
            offerAmountInput.addEventListener("input", function() {
                this.value = this.value.replace(/[^0-9]/g, "");
            });
        }

    });

</script>

@endpush
