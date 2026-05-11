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
<h3>Facebook Settings</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Site Options</li>
<li class="breadcrumb-item active">Facebook Settings</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-border table-striped table" id="facebookSettingsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Update Date</th>
                                    <th>Product Name</th>
                                    <th>FB Domain Verification Id</th>
                                    <th>FB Pixel Key</th>
                                    <th>FB Access Token</th>
                                    <th>FB Event Name</th>
                                    <th>FB Event Id</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data ?? [] as $fb)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $fb->updated_at }}</td>
                                    <td>{{ $fb->product_title }}</td>
                                    <td>{{ $fb->domain_key }}</td>
                                    <td>{{ $fb->pixel_key }}</td>
                                    <td>{{ substr($fb->access_token, 0, 6) }}************{{ substr($fb->access_token, -6) }}</td>
                                    <td>{{ $fb->event_name }}</td>
                                    <td>{{ $fb->event_id }}</td>
                                    <td>
                                        <ul class="action text-center">
                                            <li class="edit">
                                                <a href="javascript:;" class="editBtn" data-id="{{ $fb->id }}" data-domain="{{ $fb->domain_key }}" data-pixel="{{ $fb->pixel_key }}" data-token="{{ $fb->access_token }}" data-eventname="{{ $fb->event_name }}" data-eventid="{{ $fb->event_id }}">
                                                    <i class="text-success icon-pencil-alt"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="addModals">
    @include('siteoptions::facebook.modals.edit')
</div>
@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
@if(Session::has('success'))
<script>
    toastr.success('{{Session::get('
        success ')}}')

</script>
@endif
@if(session('error'))
<script>
    toastr.error('{{Session::get('
        error ')}}')

</script>
@endif
<script>
    $(document).ready(function() {
        $('#facebookSettingsTable').DataTable({
            scrollX: false
            , autoWidth: false
            , responsive: true
            , pageLength: 50
            , lengthMenu: [50, 100, 200]
            , columnDefs: [{
                    orderable: false
                    , targets: -1
                },
                {
                    orderable: false
                    , targets: 4
                }
            ]
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const modalEl = document.getElementById("editFacebookSetting");

        document.querySelectorAll(".editBtn").forEach(btn => {
            btn.addEventListener("click", () => {
                document.getElementById("id").value = btn.dataset.id;
                document.getElementById("domain_key").value = btn.dataset.domain;
                document.getElementById("pixel_key").value = btn.dataset.pixel;
                document.getElementById("access_token").value = btn.dataset.token;
                document.getElementById("event_name").value = btn.dataset.eventname;
                document.getElementById("event_id").value = btn.dataset.eventid;
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            });
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const modalEl = document.getElementById("editFacebookSetting");
        const form = document.querySelector(".updateSettingForm");
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const btn = form.querySelector("button[type='submit']");
            const formData = new FormData(form);
            form.querySelectorAll('.ajax-error').forEach(el => el.innerHTML = '');

            try {
                btn.disabled = true;
                btn.innerHTML =
                    '<span class="spinner-border spinner-border-sm"></span> Updating...';

                const res = await fetch("{{ route('manage.facebook-setting.update') }}", {
                    method: "POST"
                    , headers: {
                        "X-CSRF-TOKEN": csrf
                        , "X-Requested-With": "XMLHttpRequest"
                    }
                    , body: formData
                });
                const result = await res.json();
                btn.disabled = false;
                btn.innerHTML = "Update";
                if (res.ok && result.status === "success") {
                    toastr.success(result.message);
                    bootstrap.Modal.getInstance(modalEl).hide();
                    window.location.reload();
                } else if (res.status === 422) {
                    Object.entries(result.errors).forEach(([key, val]) => {
                        const errorBox = form.querySelector("." + key);
                        if (errorBox) {
                            errorBox.innerHTML = `<strong>${val[0]}</strong>`;
                        }
                    });
                } else {
                    toastr.error(result.message || "Update failed");
                }
            } catch (err) {
                btn.disabled = false;
                btn.innerHTML = "Update";
                toastr.error("Server error");
            }

        });

    });

</script>
@endpush
