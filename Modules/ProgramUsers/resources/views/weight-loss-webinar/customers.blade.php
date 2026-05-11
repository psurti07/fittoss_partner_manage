@extends('layouts.manage')
@section('title', 'Webinar Users')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@push('style-css')
<style>
    #customer-table_length {
        margin-left: 25px;
    }

</style>
@endpush

@section('breadcrumb-title')
<h3>Weight Loss Webinar Customers</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('contact.name') !!}</li>
<li class="breadcrumb-item active">Default</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12 text-end d-inline align-content-end">
            <div class="row g-3">
                <div class="col-md-2 position-relative text-start">
                    <label class="form-label" for="fromDate">From Date</label>
                    <input class="form-control" id="fromDate" type="date" name="fromDate" max="{{ date('Y-m-d') }}" value="{{ request('filter') == 'today' ? date('Y-m-d') :date('Y-m-d',strtotime('-10 days')) }}">
                </div>
                <div class="col-md-2 position-relative text-start">
                    <label class="form-label" for="toDate">To Date</label>
                    <input class="form-control" id="toDate" type="date" name="toDate" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-2 position-relative text-start">
                    <button type="button" class="mt-4 btn btn-outline-warning" id="filterBtn">Show</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="WLWCustomersTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Full Name</th>
                                    <th>Mobile</th>
                                    <th>Email Id</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Pincode</th>
                                    <th class="text-center">Details</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="userDetailsModals"></div>

@endsection

@push('script-src')
@include('stacks.js.manage.datatables');

<script type="text/javascript">
    // let today = new Date();
    // let twoDaysBefore = new Date();
    // twoDaysBefore.setDate(today.getDate() - 2);
    
    // let formatDate = (date) => date.toISOString().split('T')[0]; // Format YYYY-MM-DD

    // let fromDate = sessionStorage.getItem('from_date') || new URLSearchParams(window.location.search).get('from_date') || formatDate(twoDaysBefore);
    // let toDate = sessionStorage.getItem('to_date') || new URLSearchParams(window.location.search).get('to_date') || formatDate(today);
    
    // $('#fromDate').val(fromDate);
    // $('#toDate').val(toDate);

    // sessionStorage.removeItem('from_date');
    // sessionStorage.removeItem('to_date');
    
    $(function () {
        var table = $('#WLWCustomersTable').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manage.weight-loss-webinar.customers') }}",
                data: function (d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id', title: '#', orderable: false},
                {data: 'date', name: 'date'},
                {data: 'fullname', name: 'first_name'},
                {data: 'mobile_no', name: 'mobile_no'},
                {data: 'email', name: 'email'},
                {data: 'city', name: 'city'},
                {data: 'state', name: 'state'},
                {data: 'pincode', name: 'pincode'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[1, 'desc']],
            dom: 'Blfrtip',
            buttons: [ 'excel', 'csv', 'pdf', 'print' ],
            lengthMenu: [[100, 250, 500, 1000, -1], [100, 250, 500, 1000, "All"]],
            pageLength: 100,
        });
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });

</script>
@endpush

@push('script-tag')
@endpush
