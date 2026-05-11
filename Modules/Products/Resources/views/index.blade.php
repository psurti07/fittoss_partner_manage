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
<h3>Products Settings</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive1">
                        <table class="table-border table-striped table" id="productsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Update Date</th>
                                    <th>Product Title</th>
                                    <th>Product Name</th>
                                    <th>Amount</th>
                                    <th>Offer Amount</th>
                                    <th>In Offer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="addModals">
    @include('products::modals.edit')
</div>
@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
@if(Session::has('success'))
<script>
    toastr.success('{{Session::get('success')}}')
</script>
@endif
@if(session('error'))
<script>
    toastr.error('{{Session::get('error')}}')
</script>
@endif
<script>
    $(document).ready(function() {
        $('#productsTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            lengthMenu: [50, 100, 200],
            ajax: "{{ route('manage.products.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'productname', name: 'productname' },
                { data: 'product_title', name: 'product_title' },
                { data: 'amount', name: 'amount' },
                { data: 'offeramount', name: 'offeramount' },
                { data: 'inOffer', name: 'inOffer', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const modalEl = document.getElementById("editProductDetail");

           document.addEventListener("click", function (e) {
            const btn = e.target.closest(".editBtn");
            if (!btn) return;

            document.querySelector(".product-name").textContent = btn.dataset.productname;
            document.getElementById("id").value = btn.dataset.id;
            document.getElementById("amount").value = btn.dataset.amount;
            document.getElementById("offeramount").value = btn.dataset.offeramount;
            document.getElementById("inOffer").value = btn.dataset.inoffer;
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        });

    });

    document.addEventListener("DOMContentLoaded", () => {
        const modalEl = document.getElementById("editProductDetail");
        const form = document.querySelector(".updateProductForm");
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

                const res = await fetch("{{ route('manage.products.price.update') }}", {
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
