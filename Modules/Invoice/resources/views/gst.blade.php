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
<h3>GST</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Accounting</li>
<li class="breadcrumb-item active">GST</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12 text-end d-inline align-content-end">
            <div class="row g-3">
                <div class="col-md-2 position-relative text-start">
                    <label class="form-label" for="fromDate">From Date</label>
                    <input class="form-control" id="fromDate" type="date" name="fromDate" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d',strtotime('-10 days')) }}">
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
                        <table class="table table-bordered" id="GSTTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>INV Date</th>
                                    <th>INV #</th>
                                    <th>Net Amount</th>
                                    <th>CGST</th>
                                    <th>SGST</th>
                                    <th>IGST</th>
                                    <th>Total Amount</th>
                                    <th>Fullname</th>
                                    <th>Mobile</th>
                                    <th>Email Id</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>PaymentId</th>
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
    $(function() {
        var table = $('#GSTTable').DataTable({
            responsive: true
            , processing: true
            , serverSide: true
            , ajax: {
                url: "{{ route('manage.gst') }}"
                , data: function(d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                }
            }
            , columns: [{
                    data: 'DT_RowIndex'
                    , name: 'id'
                    , title: '#'
                }
                , {
                    data: 'inv_date'
                    , name: 'inv_date'
                }
                , {
                    data: 'inv_no'
                    , name: 'inv_no'
                }
                , {
                    data: 'inv_price'
                    , name: 'inv_price'
                }
                , {
                    data: 'inv_cgst'
                    , name: 'inv_cgst'
                }
                , {
                    data: 'inv_sgst'
                    , name: 'inv_sgst'
                }
                , {
                    data: 'inv_igst'
                    , name: 'inv_igst'
                }
                , {
                    data: 'inv_grandtotal'
                    , name: 'inv_grandtotal'
                }
                , {
                    data: 'fullname'
                    , name: 'fullname'
                }
                , {
                    data: 'mobile_no'
                    , name: 'mobile'
                }
                , {
                    data: 'email'
                    , name: 'email'
                }
                , {
                    data: 'city'
                    , name: 'city'
                }
                , {
                    data: 'state'
                    , name: 'state'
                }
                , {
                    data: 'payment_id'
                    , name: 'payment_id'
                }
            ]
            , order: [
                [0, 'desc']
            ]
            , dom: 'Blfrtip'
            , buttons: ['excel', 'csv', 'pdf', 'print']
            , lengthMenu: [
                [50,100, 250, 500, 1000, -1]
                , [50,100, 250, 500, 1000, "All"]
            ]
            , pageLength: 50
        , });
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });

</script>
@endpush

@push('script-tag')
@endpush
