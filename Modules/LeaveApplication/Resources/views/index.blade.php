@extends('layouts.manage')
@section('title', 'Leave Application')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Leave Application</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Leave Application</li>
@endsection

@section('content')
<div class="container-fluid">
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
<div class="addLeaveModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables');
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
<script>
        function openInfoModal(show_id) {
            $.ajax({
                url: "apply-leave-edit/" + show_id,
                type: 'GET',
                success: function(result) {
                    $('.addLeaveModals').html(result);
                    $('#showLeaveUpdate').modal('show');
                }
            });
        }
</script>
@endpush