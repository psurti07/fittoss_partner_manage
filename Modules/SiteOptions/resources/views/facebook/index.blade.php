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
                                    <th>Pixel Key</th>
                                    <th>Access Token</th>
                                    <th>Event Name</th>
                                    <th>Event Id</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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
    var table = $('#facebookSettingsTable').DataTable({
        responsive: true
        , processing: true
        , serverSide: true
        , ajax: {
            url: "{{ route('manage.facebook-setting.index') }}"
            , data: function(d) {
                d.product_id = $('#product_id').val();
            }
        }
        , columns: [{
                data: 'DT_RowIndex'
                , name: 'fpd.id'
                , title: '#'
            }
            , {
                data: 'updated_at'
                , name: 'fpd.updated_at'
            }
            , {
                data: 'product_name'
                , name: 'p.product_title'
            }
            // , {
            //     data: 'domain_key'
            //     , name: 'fpd.domain_key'
            // }
            , {
                data: 'pixel_key'
                , name: 'fpd.pixel_key'
            }
            , {
                data: 'access_token'
                , name: 'fpd.access_token'
            }
            , {
                data: 'event_name'
                , name: 'fpd.event_name'
            }
            , {
                data: 'event_id'
                , name: 'fpd.event_id'
            }
            , {
                data: 'action'
                , name: 'action'
                , orderable: false
                , searchable: false
            }
        , ]
        , columnDefs: [{
            targets: [0, 5, 6]
            , orderable: false
            , createdCell: function(td) {
                $(td).addClass('text-center');
            }
        }]
        , order: [
            [1, 'desc']
        ]
        , dom: 'Blfrtip'
        , buttons: ['excel', 'csv', 'pdf', 'print']
        , lengthMenu: [
            [100, 250, 500, 1000, -1]
            , [100, 250, 500, 1000, "All"]
        ]
        , pageLength: 100
    , });

    $('#filterBtn').on('click', function() {
        table.ajax.reload();
    });

     document.addEventListener("click", function(e) {
        if (e.target.closest(".editBtn")) {
            const btn = e.target.closest(".editBtn");
            document.getElementById("id").value = btn.dataset.id;
            // document.getElementById("domain_key").value = btn.dataset.domain;
            document.getElementById("pixel_key").value = btn.dataset.pixel;
            document.getElementById("access_token").value = btn.dataset.token;
            document.getElementById("event_name").value = btn.dataset.eventname;
            document.getElementById("event_id").value = btn.dataset.eventid;
            const modalEl = document.getElementById("editFacebookSetting");
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
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
