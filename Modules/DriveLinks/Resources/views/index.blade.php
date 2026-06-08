@extends('layouts.manage')
@section('title', 'Drive Links')

@push('style-css')
<style>
    .drive-modern-card {
        border-radius: 10px;
        border: 1px solid #f1f1f1;
        transition: all 0.2s ease;
    }

    .drive-modern-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transform: translateY(-3px);
    }

    .drive-modern-card h6 {
        font-size: 14px;
        line-height: 1.3;
        max-height: 36px;
        /* allows 2 lines */
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* limit to 2 lines */
        -webkit-box-orient: vertical;
        word-break: break-word;
    }

    .status-chip {
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 20px;
        font-weight: 500;
    }

    .active-chip {
        background: #e6f7ee;
        color: #1e8e5a;
    }

    .inactive-chip {
        background: #fdeaea;
        color: #d93025;
    }

    .btn-xs {
        padding: 3px 8px;
        font-size: 11px;
    }

    .action-btn {
        border-radius: 6px;
    }

</style>
@endpush

@section('breadcrumb-title')
<h3>Drive Links</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Drive Links</li>
@endsection

@section('content')

<div class="container-fluid social-user-cards">

    <!-- Filter + Add Button -->
    <div class="row align-items-end g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Department</label>
            <select class="form-select" id="parentid">
                <option value="">All</option>
                @foreach(\App\Models\DriveLinks::DEPARTMENTS as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 mt-auto">
            <button class="btn btn-outline-warning" id="filterBtn">Show</button>
        </div>
        {{-- <div class="col-md-7 text-end">
            <button class="btn btn-outline-primary" onclick="openAddModal()">
                <i class="fa fa-plus"></i> Add Drive Link
            </button>
        </div> --}}
    </div>


    <!-- Department Wise Cards -->
    <div id="driveLinkContainer">
        @forelse($drivelinks as $departmentId => $links)
        <!-- Department Heading -->
        <div class="mb-3 department-section" data-department="{{ $departmentId }}">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                <h6 class="fw-bold mb-0 text-dark">
                    {{ \App\Models\DriveLinks::DEPARTMENTS[$departmentId] ?? 'Unknown Department' }}
                </h6>

                <span class="badge bg-light text-dark">
                    {{ count($links) }} Links
                </span>
            </div>
        </div>

        <!-- Cards Row -->
        <div class="row g-3 mb-4 department-section" data-department="{{ $departmentId }}">
            @foreach($links as $link)
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6 drive-card" id="driveCard{{ $link->id }}" data-department="{{ $link->department }}">
                <div class="card drive-modern-card">
                    <div class="card-body p-3">
                        <!-- Top Row -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-semibold mb-1">
                                    {{ $link->title }}
                                </h6>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($link->rec_date)->format('d M Y') }}
                                </small>
                            </div>
                            <span class="status-chip 
                                {{ $link->isActive ? 'active-chip' : 'inactive-chip' }}">
                                {{ $link->isActive ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <!-- Bottom Actions -->
                        <div>
                            <!-- Top Row -->
                            {{-- <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-xs btn-light action-btn" onclick="openEditModal({{ $link->id }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-xs btn-light action-btn text-danger" onclick="deleteDriveLink({{ $link->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                <button class="btn btn-xs 
                                    {{ $link->isActive ? 'btn-outline-success' : 'btn-outline-danger' }}" id="statusBtn{{ $link->id }}" onclick="changeStatus({{ $link->id }})">
                                    {{ $link->isActive ? 'Active' : 'Inactive' }}
                                </button>
                            </div> --}}
                            <!-- Open Drive Button -->
                            <button class="btn btn-sm btn-primary w-100 mt-2" onclick="window.open('{{ $link->link }}','_blank')">
                                <i class="fa fa-folder-open"></i> Open Drive
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @empty
        <div class="text-center py-5">
            <h6 class="text-muted">No Drive Links Found</h6>
        </div>
        @endforelse
    </div>
</div>
<div class="addModalHtml"></div>
@endsection


@push('script-tag')
<script>
    $(document).ready(function() {

        // FILTER BY DEPARTMENT
        $('#filterBtn').click(function() {

            let department = $('#parentid').val();

            if (department === "") {
                $('.department-section').show();
                $('.drive-card').show();
                return;
            }

            $('.department-section').hide();
            $('.drive-card').hide();

            $('.department-section[data-department="' + department + '"]').show();
            $('.drive-card[data-department="' + department + '"]').show();
        });

    });


    // OPEN ADD MODAL
    function openAddModal() {
        $.ajax({
            url: "{{ route('manage.drive.links.create') }}"
            , type: 'GET'
            , success: function(result) {
                $('.addModalHtml').html(result);
                $('.addDriveLinkModal').modal('show');
            }
        });
    }


    // OPEN EDIT MODAL
    function openEditModal(id) {
        let url = "{{ route('manage.drive.links.edit', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            url: url
            , type: 'GET'
            , success: function(result) {
                $('.addModalHtml').html(result);
                $('.editDriveLinkModal').modal('show');
            }
        });
    }


    // DELETE
    function deleteDriveLink(id) {

        swal({
            title: "Are you sure?"
            , text: "You want to delete this Drive Link."
            , icon: "warning"
            , buttons: ["Cancel", "Confirm"]
            , dangerMode: true
        , }).then((willDelete) => {

            if (willDelete) {

                let url = "{{ route('manage.drive.links.destroy', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url
                    , type: 'DELETE'
                    , data: {
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(response) {
                        if (response.type === 'SUCCESS') {
                            toastr.success(response.message);
                            $('#driveCard' + id).remove();
                        }
                    }
                });
            }
        });
    }


    // CHANGE STATUS
    function changeStatus(id) {

        let url = "{{ route('manage.drive.links.changeStatus', ':id') }}";
        url = url.replace(':id', id);

        $.post(url, {
            _token: '{{ csrf_token() }}'
        }, function(response) {

            if (response.type === 'SUCCESS') {

                toastr.success(response.message);

                let btn = $('#statusBtn' + id);

                if (response.status) {
                    btn.removeClass('btn-outline-danger')
                        .addClass('btn-outline-success')
                        .text('Active');
                } else {
                    btn.removeClass('btn-outline-success')
                        .addClass('btn-outline-danger')
                        .text('Inactive');
                }

            }
        });
    }

</script>
@endpush
