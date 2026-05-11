{{-- @extends('welcomeimageflyer::layouts.master') --}}
@extends('layouts.manage')
@section('title', 'Welcome Image Flyer')


@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
    <style>
        .swal-title {
            font-size: 20px
        }

        #cke_descriptions {
            border: 1px solid #e9e9ec !important;
        }
    </style>
@endpush

@section('breadcrumb-title')
    <h3>Welcome Image Flyer</h3>
@endsection

@section('breadcrumb')
    <div class="row">
        <div class="col-6">
            <h3>Welcome Image Flyer</h3>
        </div>
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('manage.dashboard') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item active">Welcome Image Flyer</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 text-end">
                <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-secondary" id="add-flyer-btn"><i
                        class="fa fa-plus-square"></i>&nbsp;Add Welcome Image Flyer</a>
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
    <div class="addFlyerModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        function openAddModal() {
            $.ajax({
                url: "{!! route('manage.welcome_image_flyer.create') !!}",
                type: 'GET',
                contentType: "application/json",
                beforeSend: function() {
                    $('#add-flyer-btn').html(
                        '<span class="spinner-border spinner-border-sm"></span> Add Welcome Image Flyer');
                    $('#add-flyer-btn').attr('disabled', true);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    console.log(result);
                    $('.addFlyerModals').html(result);
                    $('#addFlyer').modal('show');
                    $('#add-flyer-btn').html('<i class="fa fa-plus-square"></i>&nbsp;Add Welcome Image Flyer');
                    $('#add-flyer-btn').attr('disabled', false);
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        }

        function destroy(updates_id) {
            swal({
                title: "Are you sure?",
                text: "You want to delete this flyer.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["Cancel", "Confirm"],
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '/welcome-image-flyer-destroy/' + updates_id,
                        type: 'POST',
                        data: JSON.stringify({
                            id: updates_id
                        }),
                        contentType: "application/json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                $('#welcomeimageflyer-table').DataTable().ajax.reload();
                            }
                        }
                    });
                }
            });
        }

        function openEditModal(updates_id) {
            $.ajax({
                url: "/welcome-image-flyer-edit/" + updates_id,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('.addFlyerModals').html(result);
                    $('#editFlyer').modal('show');
                }
            });
        }

        function toggleFlyerStatus(id) {
            if (!id) return;
            $.ajax({
                url: '/welcome-image-flyer-toggle-status/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.type === 'SUCCESS') {
                        $('#welcomeimageflyer-table').DataTable().ajax.reload(null, false);
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
