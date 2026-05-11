@extends('layouts.manage')
@section('title', 'Send OTPs')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
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
    <div class="row g-3 d-flex align-items-center">
        <div class="col-md-5 position-relative">
            <label for="product_id">Product</label>
            <select name="product_id" id="product_id" class="form-select">
                <option value="" selected>All</option>
                @foreach($products as $key => $product)
                <option value={{ $product->id }} {{ $productID == $product->id ? 'selected' :"" }}>{{ $product->product_title }}</option>
                @endforeach
            </select>
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
<script>
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
