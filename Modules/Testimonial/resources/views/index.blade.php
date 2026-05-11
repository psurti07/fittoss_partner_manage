@extends('layouts.manage')
@section('title', 'Testimonial')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@push('style-css')

@endpush

@section('breadcrumb-title')
<h3>Testimonial</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data List</li>
    <li class="breadcrumb-item active">{!! config('testimonial.name') !!}</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12 text-end">
            <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-primary"><i class="fa fa-plus-square"></i>&nbsp;Add Testimonial</a>
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

<div class="addTestimonialModal"></div>

@endsection

@push('script-src')
@include('stacks.js.manage.datatables');
@include('stacks.js.testimonial.index')
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush