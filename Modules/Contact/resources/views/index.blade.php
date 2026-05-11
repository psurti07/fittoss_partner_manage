@extends('layouts.manage')
@section('title', 'Contact Inquiry')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@push('style-css')

@endpush

@section('breadcrumb-title')
<h3>Contact Inquiry</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data List</li>
    <li class="breadcrumb-item active">Contact Inquiry</li>
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
@endsection

@push('script-src')
@include('stacks.js.manage.datatables');
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush