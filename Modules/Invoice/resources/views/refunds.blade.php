@extends('layouts.manage')
@section('title', 'Webinar Users')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Refunds</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Accounting</li>
<li class="breadcrumb-item active">Refunds</li>
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
                        <table class="table table-bordered" id="refundsTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Refund Date</th>
                                    <th>Refund #</th>
                                    <th>Net Amount</th>
                                    <th>CGST</th>
                                    <th>SGST</th>
                                    <th>IGST</th>
                                    <th>Total Amount</th>
                                    <th>Fullname</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Payment Id</th>
                                    <th>City</th>
                                    <th>State</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script-src')
@include('stacks.js.manage.datatables')

<script type="text/javascript">
    console.log('script loaded'); // debug

    $(function() {
        var table = $('#refundsTable').DataTable({
            responsive: true
            , processing: true
            , serverSide: true
            , ajax: {
                url: "{{ route('manage.refunds') }}"
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
                    data: 'created_at'
                    , name: 'created_at'
                }
                , {
                    data: 'ref_number'
                    , name: 'ref_number'
                }
                , {
                    data: 'ref_price'
                    , name: 'ref_price'
                }
                , {
                    data: 'ref_cgst'
                    , name: 'ref_cgst'
                }
                , {
                    data: 'ref_sgst'
                    , name: 'ref_sgst'
                }
                , {
                    data: 'ref_igst'
                    , name: 'ref_igst'
                }
                , {
                    data: 'ref_grandtotal'
                    , name: 'ref_grandtotal'
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
                    data: 'paymentid'
                    , name: 'paymentid'
                }
                , {
                    data: 'city'
                    , name: 'city'
                }
                , {
                    data: 'state'
                    , name: 'state'
                }
            , ]
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
