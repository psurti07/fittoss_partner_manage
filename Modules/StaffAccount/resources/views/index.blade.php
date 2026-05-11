@extends('layouts.manage')
@section('title', 'Staff Account')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
    <h3>Staff Account</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Site Options</li>
    <li class="breadcrumb-item active">Staff Accounts</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 text-end">
                <button onclick="openAddModal()" class="btn btn-outline-secondary" id="addStaffBtn"><i class="fa fa-plus-square"></i>&nbsp;Add Accounts</button>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="addAccountsModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
    @include('stacks.js.staffAccount.index')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
