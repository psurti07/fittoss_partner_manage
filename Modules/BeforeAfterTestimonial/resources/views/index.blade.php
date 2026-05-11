@extends('layouts.manage')
@section('title', 'Before After Testimonial')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@push('style-css')

@endpush

@section('breadcrumb-title')
<h3>Before After Testimonial</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data List</li>
    <li class="breadcrumb-item active">Before After Testimonial</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12 text-end">
            <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-primary"><i class="fa fa-plus-square"></i>&nbsp;Add B/A Testimonial</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="addBeforeAfterTestimonialModal"></div>

@endsection

@push('script-src')
@include('stacks.js.manage.datatables');
@include('stacks.js.beforeaftertestimonial.index')
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush