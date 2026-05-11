@extends('layouts.manage')
@section('title', 'Employee')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    
@endpush

@section('breadcrumb-title')
    <h3>Employee</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Employees</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 text-end">
                <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-secondary" id="add-employee-btn"><i class="fa fa-plus-square"></i>&nbsp;Add Employees</a>
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
    <div class="addEmployeeModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables');
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        function openAddModal(){
            $.ajax({
                url: "{!! route('manage.employee.create') !!}",
                type: 'GET',
                contentType: "application/json",
                beforeSend: function(){
                    $('#add-employee-btn').html('<span class="spinner-border spinner-border-sm"></span> Add Employee');
                    $('#add-employee-btn').attr('disabled', true);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    console.log(result);
                    $('.addEmployeeModals').html(result);
                    $('#addEmployee').modal('show');
                    $('#add-employee-btn').html('<i class="fa fa-plus-square"></i>&nbsp;Add Employee');
                    $('#add-employee-btn').attr('disabled', false);
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        }

        function toggleEmployeeStatus(id) {
            if (!id) return;
            $.ajax({
                url: 'employee-toggle-status/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.type === 'SUCCESS') {
                        $('#employee-table').DataTable().ajax.reload(null, false);
                        toastr.success(response.message);
                    } else {
                        alert(response.message || 'Failed to update status');
                    }
                },
                error: function() {
                    alert('Failed to update status');
                }
            });
        }

    </script>
@endpush
