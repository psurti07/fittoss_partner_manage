@extends('layouts.manage')
@section('title', 'Site Settings')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<style>
    .custom-rounded {
        border-radius: 10px;
    }

</style>
@endpush

@section('breadcrumb-title')
<h3>Schedule Slots</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Schedule Slots</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row d-flex align-items-center">
        <div class="col-md-2">
            <label class="form-label">Status:</label>
            <select class="form-select" name="status" id="status">
                <option value="" selected>All</option>
                @foreach(App\Models\ScheduleSlot::getStatuses() as $key => $value)
                  <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Language:</label>
            <select class="form-select" name="language" id="language">
                <option value="" selected>All</option>
                @foreach(App\Models\ScheduleSlot::getLanguages() as $key => $value)
                  <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">From Date</label>
            <input class="form-control" type="date" name="fromDate" id="fromDate"
                value="{{ date('Y-m-d', strtotime('-1 days')) }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">To Date</label>
            <input class="form-control" type="date" name="toDate" id="toDate" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-2">
            <button type="button" class="mt-4 btn btn-outline-warning" id="filterBtn">Show</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive1">
                    <table class="table-border table-striped table" id="productsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Update Date</th>
                                    <th>Product Name</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Language</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="scheduleSlotDetailModal"></div>

@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
@if(Session::has('success'))
<script>
    toastr.success('{{Session::get('success')}}')
</script>
@endif
@if(session('error'))
<script>
    toastr.error('{{Session::get('error')}}')
</script>
@endif
<script>
    $(document).ready(function() {
        var table = $('#productsTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            lengthMenu: [50, 100, 200],
            ajax: {
                url: "{{ route('manage.schedule-slot') }}",
                data: function (d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                    d.status = $('#status').val();
                    d.language = $('#language').val();
                }
            },
            order:[1,'desc'],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'updated_at', name: 'ss.updated_at' },
                { data: 'product_title', name: 'p.product_title' },
                { data: 'fullName', name: 'c.first_name' },
                { data: 'email', name: 'c.email' },
                { data: 'mobile_no', name: 'c.mobile_no' },
                { data: 'date', name: 'ss.date' },
                { data: 'time', name: 'ss.time' },
                { data: 'language', name: 'ss.language', orderable: false },
                { data: 'status', name: 'ss.status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

         $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });

    function openDetailsModal(id) {
        var show_url = "{{ route('manage.schedule-slot.show', ':id') }}";
        show_url = show_url.replace(':id', id);

        $.ajax({
            url: show_url,
            type: 'GET',
            dataType: 'html',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.scheduleSlotDetailModal').html(result);
                $('#scheduleSlotModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching support request details:", error);
                alert("Failed to load details. Please try again.");
            }
        });
    }

</script>
@endpush
