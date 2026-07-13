@extends('layouts.manage')
@section('title', 'Send OTPs')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('breadcrumb-title')
<h3>Send OTPs</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">SMS Data</li>
<li class="breadcrumb-item active">Send OTPs</li>
@endsection

@php
$productID = request('id');
@endphp

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12">
            <div class="row g-3 d-flex align-items-center">
                <div class="col-md-3 position-relative">
                    <x-product-dropdown />
                    @component('components.ajax-error', ['field' => 'product_id'])@endcomponent
                </div>
                <div class="col-md-2 position-relative">
                    <label class="form-label">From Date</label>
                    <input class="form-control" type="date" name="fromdate" id="fromdate" value="{{ request('filter') == 'today' ? date('Y-m-d') : date('Y-m-d',strtotime('-2 days')) }}">
                </div>
                <div class="col-md-2 position-relative">
                    <label class="form-label">To Date</label>
                    <input class="form-control" type="date" name="todate" id="todate" value="{{ request('todate', date('Y-m-d')) }}">
                </div>
                <div class="col-md-2 position-relative">
                    <button type="button" class="mt-4 btn btn-outline-warning" id="dateBtn">Show</button>
                </div>
            </div>
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
@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes:['type' => 'module']) }}

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $('#product_id').select2({
        placeholder: 'Search Product',
        allowClear: true,
        width: '100%'
    });
    const table = $("#sendotp-table");
    table.on('preXhr.dt', function(e, settings, data) {
        data.start_date = $("#fromdate").val();
        data.end_date = $("#todate").val();
        data.product_id = $("#product_id").val();
    });
    $('#dateBtn').on('click', function() {
        table.DataTable().ajax.reload();
        return false;
    })

</script>
@endpush
