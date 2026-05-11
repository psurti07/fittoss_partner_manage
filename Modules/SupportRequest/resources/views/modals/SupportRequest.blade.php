<div>
    <div class="modal fade" id="SupportRequestModal" tabindex="-1" aria-labelledby="SupportRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SupportRequestModalLabel">Support Request Ticket Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">Ticket No:&nbsp;<b>{{ $supportRequest->ticketno }}</b></li>
                                        <li class="list-group-item"> Request Date:&nbsp;<b> {{ $supportRequest->rec_date }}</b></li>
                                        <li class="list-group-item">User Type:&nbsp;<b>
                                                @if($supportRequest->usertype == 1)
                                                customer
                                                @elseif($supportRequest->usertype == 2)
                                                guest user
                                                @else
                                                Unknown
                                                @endif
                                            </b></li>
                                        <li class="list-group-item"> Full Name:&nbsp;<b> {{ $supportRequest->firstname }} {{ $supportRequest->lastname }}</b></li>
                                        <li class="list-group-item"> Mobile :&nbsp;<b>{{ $supportRequest->mobile }}</b></li>
                                        <li class="list-group-item"> Email :&nbsp;<b>{{ $supportRequest->email }}</b></li>
                                        <li class="list-group-item"> Issue Type :&nbsp;<b>{{ $supportRequest->issuetype }}</b></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="btn-group mb-3">
                                        <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Status</button>
                                        <ul class="dropdown-menu dropdown-block">
                                            <li><a class="dropdown-item" href="javascript:;" onclick="changeStatus(2, {{ $supportRequest->id }})">Under Process</a></li>
                                            <li><a class="dropdown-item" href="javascript:;" onclick="changeStatus(3, {{ $supportRequest->id }})">Closed</a></li>
                                            <li><a class="dropdown-item" href="javascript:;" onclick="changeStatus(4, {{ $supportRequest->id }})">Contact Request</a></li>
                                            <li><a class="dropdown-item" href="javascript:;" onclick="changeStatus(5, {{ $supportRequest->id }})">Not in Contact</a></li>
                                        </ul>
                                    </div>
                                    <ul class="list-group">
                                        @php
                                            switch ($supportRequest->status) {
                                                  case '1':
                                                    echo '<p class="badge-default badge-info text-center text-white">Ticket is currently open.</p>';
                                                    break;

                                                  case '2':
                                                    echo '<p class="badge-default badge-danger text-center text-white">Ticket is under processing.</p>';
                                                    break;

                                                  case '3':
                                                    echo '<p class="badge-default badge-warning text-center text-white">Ticket is closed.</p>';
                                                    break;

                                                  case '4':
                                                    echo '<p class="badge-default badge-success text-center text-white">Ticket is successfully resolved.</p>';
                                                    break;

                                                  case '5':
                                                    echo '<p class="badge-default badge-success text-center text-white">Ticket is closed, due to no customer response.</p>';
                                                    break;
                                                }
                                        @endphp
                                        <li class="list-group-item text-danger">
                                            Customer :
                                            <strong>{{ $supportRequest->message }}</strong>
                                        </li>
                                        <div class="my-2"></div>
                                        
                                        @if(count($remarks))
                                            @foreach($remarks as $remark)
                                                <li class="list-group-item mb-3">
                                                    {{ $remark->administrations->fullname ?? 'Unknown User' }}: 
                                                    <b>{{ $remark->remarks }}</b><br>
                                                    <small><em>{{ \Carbon\Carbon::parse($remark->rec_date)->format('d/m/Y') }}</em></small>
                                                </li>
                                            @endforeach
                                        @endif
                                        
                                       <p id="remarksdetails"></p>
                                    </ul>
                                    <form method="post" action="{{ route('supportrequest.add-remark') }}" id="submitForm" class="form-horizontal">
                                        @csrf
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <input type="hidden" name="requestid" id="requestid" value="{{ $supportRequest->id }}">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="remarks" id="remarks" placeholder="Staff Remark" aria-describedby="button-addon6"></textarea>
                                                    <style>
                                                        .invalid-feedback {
                                                            display: block;
                                                            font-weight: 100 !important;
                                                            font-size: 14px !important;
                                                        }
                                                    </style>
                                                    <span class="invalid-feedback ajax-error remarks is-invalid text-danger" role="alert"></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" id="add-remarks" class="btn btn-outline-success add-remarks">Add Remarks</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function changeStatus(status, requestId) {
        $.ajax({
            url: "{{ route('supportrequest.change-status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                supportId: requestId,
                status: status
            },
            success: function(response){
                if (response.type === 'SUCCESS') {
                    $('#current-status').html("");
                    let statusText = "";
                    let statusClass = "";

                    switch (response.data) {
                        case '1':
                            statusText = "Ticket is currently open.";
                            statusClass = "badge-info";
                            break;
                        case '2':
                            statusText = "Ticket is under processing.";
                            statusClass = "badge-danger";
                            break;
                        case '3':
                            statusText = "Ticket is closed, due to no customer response.";
                            statusClass = "badge-warning";
                            break;
                        case '4':
                            statusText = "Ticket is successfully resolved.";
                            statusClass = "badge-success";
                            break;
                        default:
                            statusText = "Unknown Status";
                            statusClass = "badge-secondary";
                    }

                    let html = `<li class="list-group-item" id="current-status">
                        <p class="badge-default ${statusClass} text-center text-white">${statusText}</p>
                    </li>`;
                    $('#current-status').html(html);
                    $("#supportrequest-table").DataTable().ajax.reload()
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
        })
    }

    $('#submitForm').submit(function (event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var data = new FormData(this);
            $.ajax({
                url: $(this).attr("action"),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#add-remarks').html('<span class="spinner-border spinner-border-sm"></span> Adding Remarks');
                    $('#add-remarks').attr('disabled', true);
                },
                success: function (result) {
                    $('#add-remarks').html("Add Remarks");
                    $('#add-remarks').attr('disabled', false);

                    if (result.type === 'SUCCESS') {
                        $('#submitForm')[0].reset();
                        
                        toastr.success(result.message);

                        let html = "";
                        $.each(result.data, function (index, item) {
                            html += `<li class='list-group-item'>
                                ${item.administrations.fullname} - <small><em>${new Date(item.rec_date).toLocaleDateString()}</em></small><br/>
                                <b>${item.remarks}</b>
                            </li>`;
                        });
                        $('#remarksdetails').html(html);
                    } else {
                        toastr.error(result.message);
                    }
                },
                error: function (error) {
                    $('#add-remarks').html("Add Remarks");
                    $('#add-remarks').attr('disabled', false);
                    
                    let errors = error.responseJSON.errors, errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    toastr.error('Failed to add remarks.');
                }
            });
        }
    });
</script>

