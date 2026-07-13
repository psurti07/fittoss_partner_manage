@extends('layouts.manage')
@section('title', 'Site Settings')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .custom-rounded {
        border-radius: 10px;
    }

</style>
@endpush

@section('breadcrumb-title')
<h3>Whatsapp Settings</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Site Options</li>
<li class="breadcrumb-item active">Whatsapp Settings</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12 text-end d-inline align-content-end">
            <div class="row g-3 d-flex align-items-center">
                <div class="col-md-3 position-relative text-start">
                    <x-product-dropdown />
                </div>
                <div class="col-md-2 position-relative text-start">
                    <button type="button" class="mt-4 btn btn-outline-warning" id="filterBtn">Show</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="whatsappSettingTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Update Date</th>
                                    <th>Product Name</th>
                                    <th>Event Name</th>
                                    <th>Template Name</th>
                                    <th class="text-center">Action</th>
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
    @include('siteoptions::whatsapp.modals.edit')
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $('#product_id').select2({
        placeholder: 'Search Product',
        allowClear: true,
        width: '100%'
    });
    var table = $('#whatsappSettingTable').DataTable({
        responsive: true
        , processing: true
        , serverSide: true
        , ajax: {
            url: "{{ route('manage.whatsapp-setting.index') }}"
            , data: function(d) {
                d.product_id = $('#product_id').val();
            }
        }
        , columns: [{
                data: 'DT_RowIndex'
                , name: 'ws.id'
                , title: '#'
            }
            , {
                data: 'updated_at'
                , name: 'ws.updated_at'
            }
            , {
                data: 'product_name'
                , name: 'p.product_title'
            }
            , {
                data: 'event_name'
                , name: 'ws.event_name'
            }
            , {
                data: 'template_name'
                , name: 'ws.template_name'
            }
            , {
                data: 'action'
                , name: 'action'
                , orderable: false
                , searchable: false
            }
        , ]
        , columnDefs: [{
            targets: [0]
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

            console.log(btn.dataset);

            document.getElementById("id").value = btn.dataset.id;
            document.getElementById("key").value = btn.dataset.key;
            document.getElementById("media_name").value = btn.dataset.media_name;
            document.getElementById("media_url").value = btn.dataset.media_url;
            document.getElementById("template_name").value = btn.dataset.template_name;

            const modalEl = document.getElementById("editWhatsappSetting");
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    });


    document.addEventListener("DOMContentLoaded", () => {
        const modalEl = document.getElementById("editWhatsappSetting");
        const form = document.querySelector("#updateWhatsappSettingForm");
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

                const res = await fetch("{{ route('manage.whatsapp-setting.update') }}", {
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
                    table.ajax.reload();
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
