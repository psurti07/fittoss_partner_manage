@extends('layouts.manage')
@section('title', 'Career')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@push('style-css')

@endpush

@section('breadcrumb-title')
<h3>Career</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Data List</li>
    <li class="breadcrumb-item">Career</li>
    <li class="breadcrumb-item active">Career Openings</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12 text-end">
            <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-secondary"><i class="fa fa-plus-square"></i>&nbsp;Add Career</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="addCareerModal"></div>

@endsection

@push('script-src')
@include('stacks.js.manage.datatables');
@include('stacks.js.career.index')
<script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/editor/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('assets/js/editor/ckeditor/styles.js') }}"></script>
<script src="{{ asset('assets/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
<script>
    const table = $("#career-table");
    table.on('preXhr.dt', function(e, settings, data) {
        data.start_date = $("#fromdate").val();
        data.end_date = $("#todate").val();
    });
    $('#dateBtn').on('click', function() {
        table.DataTable().ajax.reload();
        return false;
    })
    CKEDITOR.replace( 'career_content');

    function changeStatus(id, currentStatus) {
        let newStatus = currentStatus ? 0 : 1;

        $.ajax({
            url: '{{ route("career.changeStatus") }}',
            type: 'POST',
            data: {
                id: id,
                is_active: newStatus,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#career-table').DataTable().ajax.reload();

                    toastr.success(response.message, '');
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function() {
                toastr.error('Something went wrong. Please try again.', 'Error');
            }
        });
    }
</script>
@endpush
