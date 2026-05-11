@extends('layouts.manage')
@section('title', 'Invoice')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Invoices</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Accounting</li>
<li class="breadcrumb-item active">Invoices</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-md-2 position-relative">
            <label class="form-label">From Date</label>
            <input class="form-control" type="date" name="fromdate" id="fromdate" value="{{ date('Y-m-d',strtotime('-7 days')) }}">
        </div>
        <div class="col-md-2 position-relative">
            <label class="form-label">To Date</label>
            <input class="form-control" type="date" name="todate" id="todate" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-2 position-relative">
            <button type="button" class="mt-4 btn btn-outline-warning" id="dateBtn">Show</button>
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
<div class="refundSection"></div>
@include('invoice::modals.refund')
@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
{{ $dataTable->scripts(attributes:['type' => 'module']) }}
<script>
    const table = $("#invoice-table");
    table.on('preXhr.dt', function(e, settings, data) {
        data.start_date = $("#fromdate").val();
        data.end_date = $("#todate").val();
    });
    $('#dateBtn').on('click', function() {
        table.DataTable().ajax.reload();
        return false;
    })

    function openRefundModal(invId, invNo) {
        $('#refundModal input[name="invoiceid"]').val(invId);
        $('#refundModal #invoiceNumberText').text(invNo);

        $('#refundModal').modal('show');
    }

    $(document).on('submit', '#save-refund-form', function (e) {
        e.preventDefault();

        console.log('AJAX submit triggered');

        let form = $(this);
        let formData = new FormData(this);

        $.ajax({
            url: form.attr('action'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (result) {
                if (result.type === 'SUCCESS') {
                    toastr.success(result.message);
                    $('#refundModal').modal('hide');
                    table.DataTable().ajax.reload();
                } else {
                    toastr.error(result.message);
                }
            },
            error: function (error) {
                let errors = error.responseJSON.errors, errorsHtml = '';
                $.each(errors, function (key, value) {
                    errorsHtml = '<strong>' + value[0] + '</strong>';
                    $('.' + key).html(errorsHtml);
                });
            }
        });
    });

    function deleteInvoice(id) {
        swal({
            title: "Are you sure?",
            text: "You want to delete this Invoice.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                var delete_url = "{{ route('manage.invoice.delete', ':id') }}";
                delete_url = delete_url.replace(':id', id);
                $.ajax({
                    url: delete_url,
                    type: 'DELETE',
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        if (result.type === 'success') {
                            toastr.success(result.message);
                            $('#invoice-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }

</script>

@endpush
@push('script-tag')
@endpush
