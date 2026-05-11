@extends('layouts.manage')
@section('title', 'Yearly Holiday List')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    
@endpush

@section('breadcrumb-title')
    <h3>Yearly Holiday List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Yearly Holiday List</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row align-items-end mb-3">

            <div class="col-md-2">
                <label class="form-label">Month</label>
                <select class="form-select" name="month_id" id="month_filter">
                    <option value="">All</option>
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Holiday Type</label>
                <select class="form-select" name="holiday_type" id="holiday_type_filter">
                    <option value="">All</option>
                    <option value="0">Full Day</option>
                    <option value="1">Half Day</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Holiday Status</label>
                <select class="form-select" name="holiday_status" id="holiday_status_filter">
                    <option value="">All</option>
                    <option value="upcoming">Upcoming Holidays</option>
                    <option value="previous">Previous Holidays</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="button" class="btn btn-outline-warning w-100" id="dateBtn">Show</button>
            </div>

            <div class="col-md-4 text-end">
                <a href="javascript:;" class="btn btn-outline-primary" id="createHolidayList" onclick="openAddModal()"><i class="fa fa-plus"></i>&nbsp;Add Yearly Holiday List</a>
            </div>

        </div>
        <div class="row mt-3"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="addHolidayListModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables');
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        function openAddModal(){
            $.ajax({
                url: "{!! route('manage.holiday-list.create') !!}",
                type: 'GET',
                contentType: "application/json",
                beforeSend: function(){
                    $('#add-holiday-list-btn').html('<span class="spinner-border spinner-border-sm"></span> Add Yearly Holiday List');
                    $('#add-holiday-list-btn').attr('disabled', true);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    console.log(result);
                    $('.addHolidayListModals').html(result);
                    $('#addHolidayList').modal('show');
                    $('#add-holiday-list-btn').html('<i class="fa fa-plus-square"></i>&nbsp;Add Holiday List');
                    $('#add-holiday-list-btn').attr('disabled', false);
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        }

        function destroy(updates_id){
            swal({
                title: "Are you sure?",
                text: "You want to delete this Holiday.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["Cancel","Confirm"],
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: 'holiday-list-destroy/' + updates_id,
                        type: 'POST',
                        data:  JSON.stringify({id: updates_id}),
                        contentType: "application/json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                $('#holidaylist-table').DataTable().ajax.reload();
                            }
                        }
                    });
                }
            });
        }

        function openEditModal(updates_id) {
            $.ajax({
                url: "holiday-list-edit/" + updates_id,
                type: 'GET',
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('.addHolidayListModals').html(result);
                    $('#editHolidayList').modal('show');
                }
            });
        }
        
        $(document).ready(function() {
            $('#dateBtn').on('click', function() {
                let month = $('#month_filter').val();
                let holiday_type = $('#holiday_type_filter').val();
                let holiday_status = $('#holiday_status_filter').val();

                $('#holidaylist-table').DataTable().ajax.url(
                    '{{ route("manage.holiday-list.index") }}'
                    + '?holiday_date=' + month
                    + '&holiday_type=' + holiday_type
                    + '&holiday_status=' + holiday_status
                ).load();
            });
        });
    </script>
@endpush