@extends('layouts.manage')
@section('title', 'Faqs')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@push('style-css')

@endpush

@section('breadcrumb-title')
<h3>Faqs</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('faq.name') !!}</li>
<li class="breadcrumb-item active">Default</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row g-3">
        @can('faqs-create')
        <div class="col-12 text-end">
            <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-primary"><i class="fa fa-plus-square"></i>&nbsp;Add Faq</a>
        </div>
        @endcan
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="addFaqsModal"></div>
@endsection

@push('script-src')
@include('stacks.js.manage.datatables');
@include('stacks.js.faq.index')
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush