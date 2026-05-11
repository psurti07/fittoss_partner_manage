@extends('layouts.manage')
@section('title', 'Role')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@push('style-css')

@endpush

@section('breadcrumb-title')
<h3>Role</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('role.name') !!}</li>
<li class="breadcrumb-item active">Default</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row g-3">
        @can('role-create')
        <div class="col-12 text-end">
            <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-primary"><i class="fa fa-plus-square"></i>&nbsp;Add Role</a>
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

<div class="addRolesModal"></div>
@endsection

@push('script-src')
@include('stacks.js.manage.datatables');
@include('stacks.js.role.index')
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush