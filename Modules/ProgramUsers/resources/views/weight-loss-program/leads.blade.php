@extends('layouts.manage')
@section('title', 'Weight Loss Program Leads')

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
<h3>Weight Loss Program Leads</h3>
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
                    <input class="form-control" id="fromDate" type="date" name="fromDate" max="{{ date('Y-m-d') }}" value="{{ request('filter') == 'today' ? date('Y-m-d') : date('Y-m-d',strtotime('-10 days')) }}">
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
                        <table class="table table-bordered" id="WLPLeadsTable" style="width:100%">
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
                                    <!-- hidden export columns -->
                                    <th>Height</th>
                                    <th>Weight</th>
                                    <th>BMI</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Medical Issue</th>
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
<div class="showInfoModals"></div>

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
        var table = $('#WLPLeadsTable').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manage.weight-loss-program.leads') }}",
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

                // extra export columns
                {data: 'height', name: 'height', visible: false},
                {data: 'weight', name: 'weight', visible: false},
                {data: 'bmi', name: 'bmi', visible: false},
                {data: 'age', name: 'age', visible: false},
                {data: 'gender', name: 'gender', visible: false},
                {data: 'medical_issue', name: 'medical_issue', visible: false},

                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[1, 'desc']],
            dom: 'Blfrtip',
            buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
            ],
            lengthMenu: [[100, 250, 500, 1000, -1], [100, 250, 500, 1000, "All"]],
            pageLength: 100,
        });
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });

    function openInfoModal(infoId){
        $.ajax({
            url: "{!! route('manage.weight-loss-program.leads.info') !!}",
            type: 'POST',
            data:  JSON.stringify({infoId: infoId}),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.showInfoModals').html(result);
                $('#infoModals').modal('show');
            }
        });
    }

    $(document).ready(function(){
        if(sessionStorage.getItem('infoId')!==null){
            openInfoModal(sessionStorage.getItem('infoId'));
            sessionStorage.removeItem('infoId');
        }
    })
</script>
@endpush

@push('script-tag')
@endpush
