@extends('layouts.manage')
@section('title', 'Career Enquiry')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@section('breadcrumb-title')
<h3>Career Enquiry</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data List</li>
    <li class="breadcrumb-item">Career</li>
    <li class="breadcrumb-item active">Career Enquiry</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="addCareerEnquiryModal"></div>

@endsection

@push('script-src')
@include('stacks.js.manage.datatables');
@include('stacks.js.careerEnquiry.index')
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

