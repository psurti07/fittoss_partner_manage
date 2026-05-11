@extends('layouts.manage')
@section('title', 'Rematrketing Log')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
    <h3>Remarketing Log</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{!! config('dashboard.name') !!}</li>
    <li class="breadcrumb-item active">Remarketing Log</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-3 position-relative">
                <label class="form-label">SMS:</label>
                <select class="form-select" name="crontype" id="crontype">
                    <option value="" selected>All</option>
                    <option value="SMS">SMS Messages</option>
                    <option value="WhatsApp">WhatsApp Messages</option>
                    <option value="RCS">RCS Messages</option>
                    <option value="reminder">Reminder Messages</option>
                    <option value="support">Support Messages</option>
                </select>
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label">From Date</label>
                <input class="form-control" type="date" name="fromdate" id="fromdate"
                    value="{{ date('Y-m-d', strtotime('-1 days')) }}">
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
                        <div class="text-right mt-3">
                            <strong>Total Messages:</strong> <span id="total-msgcount">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="showRemarketingModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        const table = $("#remarketinglog-table");
        table.on('preXhr.dt', function(e, settings, data) {
            data.start_date = $("#fromdate").val();
            data.end_date = $("#todate").val();
            data.crontype = $("#crontype").val();
        });
        $('#dateBtn').on('click', function() {
            table.DataTable().ajax.reload();
            return false;
        })

        // Handle response and show total msgcount
        table.on('xhr.dt', function(e, settings, json, xhr) {
            if (json.totalMsgCount !== undefined) {
                document.getElementById('total-msgcount').textContent = json.totalMsgCount;
            } else {
                document.getElementById('total-msgcount').textContent = '0';
            }
        });

        function openRemarketingModal(remarketingId) {
            $.ajax({
                url: `/remarketing-log/details/${remarketingId}`,
                type: 'GET',
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('.showRemarketingModals').html(result);
                    $('#remarketingLogDetails').modal('show');
                }
            });
        }
    </script>
@endpush
