@extends('layouts.manage')
@section('title', 'Sms Message')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
    <h3>SMS Message</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">SMS Data</li>
    <li class="breadcrumb-item active">SMS Message</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-3 position-relative">
            <a href="javascript:;" onclick="openModal()" class="btn btn-outline-warning" id="testBtn"><i class="icofont icofont-paper-plane" style="font-size:17px"></i>&nbsp;Test SMS</a>

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


    <div class="addSmsModals"></div>
    <div class="addMessageModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        function editModal(updates_id) {
            $.ajax({
                url: "sms-message-edit/" + updates_id,
                type: 'GET',
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('.addSmsModals').html(result);
                    $('#editSms').modal('show');
                }
            });
        }

        function openModal() {
            $.ajax({
                url: "{{ route('manage.sms.send.test.sms') }}",
                type: 'GET',
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('.addMessageModals').html(result);
                    $('#sendTestMsg').modal('show');
                }
            });
        }
    </script>
@endpush
