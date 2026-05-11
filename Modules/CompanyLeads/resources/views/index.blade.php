
@extends('layouts.manage')
@section('title', 'User Lead')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
    <h3>User Lead</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">User Lead</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-2 position-relative">
                <label class="form-label">From Date</label>
                <input class="form-control" type="date" name="fromdate" id="fromdate" value="{{ date('Y-m-d',strtotime('-2 days')) }}">
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label">To Date</label>
                <input class="form-control" type="date" name="todate" id="todate" value="{{ date('Y-m-d') }}">
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
    <div class="userDetailsModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes:['type' => 'module']) }}
    <script>
        const table = $("#companyleads-table");
        table.on('preXhr.dt',function(e, settings, data){
            data.start_date = $("#fromdate").val();
            data.end_date = $("#todate").val();
        });
        $('#dateBtn').on('click',function () {
            table.DataTable().ajax.reload();
            return false;
        })
    </script>
@endpush
