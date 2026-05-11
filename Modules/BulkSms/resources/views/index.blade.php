
@extends('layouts.manage')
@section('title', 'Bulk SMS')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
    <h3>Bulk Sms</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">SMS Data</li>
    <li class="breadcrumb-item active">Bulk Sms</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-end align-items-center g-3">
            <div class="col-md-8">
                <div class="row pull-left">
                    <div class="col-md-5 position-relative">
                        <label class="form-label">From Date</label>
                        <input class="form-control" type="date" name="fromdate" id="fromdate" value="{{ date('Y-m-d',strtotime('-8 days')) }}">
                    </div>
                    <div class="col-md-5 position-relative">
                        <label class="form-label">To Date</label>
                        <input class="form-control" type="date" name="todate" id="todate" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 position-relative">
                        <button type="button" class="mt-4 btn btn-outline-warning" id="dateBtn">Show</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ms-auto">
                <div class="d-flex gap-2">
                    <div class="text-end d-block">
                        <input type="file" id="csvFile" name="csv_file" accept=".csv" class="d-none">
                        <button type="button" class="btn btn-sm btn-outline-danger" id="uploadBtn"><i class="fa fa-upload"></i>&nbsp;Upload Data</button>
                        <small id="fileName" class="text-muted text-truncate d-block" style="max-width:150px;"></small>
                    </div>
                    <div>
                        <a href="{{ asset('assets/csv/leadsremarketing-sample.csv') }}" target="_blank" type="button" class="btn btn-sm btn-outline-primary px-2" id="downloadBtn">
                        <i class="fa fa-download"></i>&nbsp;Download Sample</a>
                    </div>
                </div>
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
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
    {{ $dataTable->scripts(attributes:['type' => 'module']) }}
    <script>
        const table = $("#bulksms-table");
        table.on('preXhr.dt',function(e, settings, data){
            data.start_date = $("#fromdate").val();
            data.end_date = $("#todate").val();
        });
        $('#dateBtn').on('click',function () {
            table.DataTable().ajax.reload();
            return false;
        })

                /* upload csv script */
        $(document).ready(function() {
            // Trigger file input when button is clicked
            $('#uploadBtn').click(function() {
                $('#csvFile').click();
            });

            // Clear file input on click to allow selecting the same file again
            $('#csvFile').on('click', function() {
                $(this).val('');
            });

            $('#csvFile').change(function() {
                var fileName = $(this).val().split('\\').pop();
                if (fileName) {
                    $('#fileName').text(fileName).removeClass('text-muted').addClass('text-primary');

                    // Auto-process the file after selection
                    processCsvFile();
                } else {
                    $('#fileName').text('No file chosen').removeClass('text-primary').addClass('text-muted');
                }
            });

            function processCsvFile() {
                var formData = new FormData();
                formData.append('csv_file', $('#csvFile')[0].files[0]);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('manage.blog.remarketing.upload') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#uploadBtn').prop('disabled', true).html('<i class="fa fa-spinner"></i> Processing...');
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        $('#bulksms-table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.error || 'Error processing file');
                    },
                    complete: function() {
                        $('#fileName').text('');
                        $('#uploadBtn').prop('disabled', false).html('<i class="fa fa-upload"></i> Upload Data');
                        $('#csvFile').val(''); // Reset file input to allow re-uploading the same file
                    }
                });
            }
        });


        /* delete the record */
        function destroy(bulksmsid) {
            swal({
                title: "Are you sure?",
                text: "You want to delete this record.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["Cancel", "Confirm"],
            }).then((willDelete) => {
                if (willDelete) {
                    //var pic = $(this).data('photo')
                    $.ajax({
                        url: '{!! route('manage.blog.remarketing.destroy')  !!}',
                        type: 'POST',
                        data: JSON.stringify({
                            id: bulksmsid
                        }),
                        contentType: "application/json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                $('#bulksms-table').DataTable().ajax.reload();
                            } else {
                                toastr.error(result.message);
                            }
                        }
                    });
                }
            });
        }
    </script>
@endpush
