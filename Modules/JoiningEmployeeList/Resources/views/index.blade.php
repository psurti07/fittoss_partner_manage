@extends('layouts.manage')
@section('title', 'Joining List')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    
@endpush

@section('breadcrumb-title')
    <h3>Joining List</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Joining List</li>
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
                <button type="button" class="btn btn-outline-warning w-100" id="dateBtn">Show</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="addEmployeeModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables');
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#dateBtn').on('click', function () {
                var selectedMonth = $('#month_filter').val();
                window.LaravelDataTables['joiningemployee-table'].ajax.url('{{ route('manage.joining-list.index') }}?month_id=' + selectedMonth).load();
            });
        });

        function openInfoModal(show_id) {
            $.ajax({
                url: "employee-show/" + show_id,
                type: 'GET',
                success: function(result) {
                    $('.addEmployeeModals').html(result);
                    $('#showEmployee').modal('show');
                }
            });
        }
    </script>
@endpush
