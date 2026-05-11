@extends('layouts.manage')
@section('title', 'Site Settings')

@push('style-css')
<style>
    .cke_inner {
        border: 1px solid #eee !important;
    }

</style>
@endpush

@section('breadcrumb-title')
<h3>Products update</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href={{ route('manage.products.index')}}>Products</a></li>
<li class="breadcrumb-item active">Products update</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('manage.products.update', $product->id) }}" method="POST" class="mt-2" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <h6 class="text-muted">Product Name : {{ $product->product_title }}</h6>
                            <div class="col-6 form-group">
                                <div class="row g-3">
                                    <div class="col-12 form-group">
                                        <label>Product Title <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="productname" id="productname" value="{{ old('productname', $product->productname) }}" class="form-control">
                                        </div>
                                        @component('components.ajax-error',['field'=>'productname'])@endcomponent
                                        @error('productname')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mt-1">
                                    <div class="col-12 form-group">
                                        <label for="description">Description</label>
                                        <textarea id="description" name="description" cols="10" rows="5" class="">{{ $product->description}}</textarea>
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

                            <div class="col-6 form-group">
                                <div class="row g-3">
                                    <div class="col-6 form-group">
                                        <div class="form-group">
                                            <label>Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="amount" id="amount" value="{{ old('amount', $product->amount) }}">
                                            </div>
                                        </div>
                                        @component('components.ajax-error',['field'=>'amount'])@endcomponent
                                        @error('amount')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-6 form-group">
                                        <div class="form-group">
                                            <label>Offer Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="offeramount" id="offeramount" value="{{ old('offeramount', $product->offeramount) }}">
                                            </div>
                                        </div>
                                        @component('components.ajax-error',['field'=>'offeramount'])@endcomponent
                                        @error('offeramount')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mt-1">
                                    <div class="col-6 form-group">
                                        <label>Coach Name</label>
                                        <div class="input-group">
                                            <input type="text" name="coach_name" id="coach_name" value="{{ old('coach_name', $product->coach_name) }}" class="form-control">
                                        </div>
                                        @component('components.ajax-error',['field'=>'coach_name'])@endcomponent
                                        @error('coach_name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="date">Date</label>
                                        <input class="form-control" type="date" id="date" value="{{ old('date',optional($product->date)->format('Y-m-d')) }}" name="date">
                                        @component('components.ajax-error', ['field' => 'date'])@endcomponent
                                        @error('date')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mt-1">
                                    <div class="col-6 form-group">
                                        <label for="start_time">Start Time</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time',optional($product->start_time)->format('H:i')) }}">
                                        @component('components.ajax-error', ['field' => 'start_time'])@endcomponent
                                        @error('start_time')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="end_time">End Time</label>
                                        <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', optional($product->end_time)->format('H:i')) }}">
                                        @component('components.ajax-error', ['field' => 'end_time'])@endcomponent
                                        @error('end_time')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mt-1">
                                    <div class="col-6 form-group">
                                        <label>Language</label>
                                        <div class="input-group">
                                            <select name="language" id="language" class="form-control">
                                                <option selected value="">Select Language</option>
                                                <option {{ ($product->language == "hindi") ? 'selected' : '' }} value="hindi">Hindi</option>
                                                <option {{ ($product->language == "english") ? 'selected' : '' }} value="english">English</option>
                                                <option {{ ($product->language == "gujarati") ? 'selected' : '' }} value="gujarati">Gujarati</option>
                                                <option {{ ($product->language == "hinglish") ? 'selected' : '' }} value="hinglish">Hinglish</option>
                                            </select>
                                        </div>
                                        @component('components.ajax-error',['field'=>'language'])@endcomponent
                                        @error('language')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>In Offer</label>
                                        <div class="input-group">
                                            <select name="inOffer" id="inOffer" class="form-control">
                                                <option {{ ($product->inOffer == 1) ? 'selected' : '' }} value=1>Yes</option>
                                                <option {{ ($product->inOffer == 0) ? 'selected' : '' }} value=0>No</option>
                                            </select>
                                        </div>
                                        @component('components.ajax-error',['field'=>'inOffer'])@endcomponent
                                        @error('inOffer')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mt-1">
                                    <div class="col-6 form-group">
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
                                        <img src="{{ $product->image_url }}" width="120px" id="imgpreview" class="mt-3">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 d-flex justify-content-end gap-2">
                                <a href="{{ route('manage.products.index') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-outline-primary">Update</button>
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
        const offerAmountInput = document.getElementById("offeramount");
        if (offerAmountInput) {
            offerAmountInput.addEventListener("input", function() {
                this.value = this.value.replace(/[^0-9]/g, "");
            });
        }

    });

</script>

@endpush
