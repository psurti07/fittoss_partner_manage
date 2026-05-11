<div class="modal fade" id="infoModals" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lead Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mt-1 f-m-light text-muted">https://fittoss.com/process?id={{ urlencode(encryptData($details->id)) }}</p>
                <p class="mt-1 f-m-light text-muted">https://fittoss.com/schedule-slot?id={{ urlencode(encryptData($details->id)) }}</p>
                @if($details->is_active === 0)
                <p class="mt-1 f-m-light"><code class="text-danger">Note:- This user is blocked</code>.</p>
                @endif
                @if($details->is_dnd === 1)
                <p class="mt-1 f-m-light"><code class="text-danger">Note:- User has been set to DND</code>.</p>
                @endif
                <ul class="nav nav-pills nav-success" id="pills-warning-tab" role="tablist">
                    {{-- Customer Details --}}
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-warning-details-tab" data-bs-toggle="pill" href="#pills-warning-details" role="tab" aria-controls="pills-warning-details" aria-selected="true" data-bs-original-title="" title="">
                            <i class="icofont icofont-business-man-alt-1"></i>Customer Details
                        </a>
                    </li>
                    {{-- Personal Details --}}
                    <li class="nav-item">
                        <a class="nav-link" id="pills-personal-details-tab" data-bs-toggle="pill" href="#pills-personal-details" role="tab" aria-controls="pills-personal-details" aria-selected="false" data-bs-original-title="" title="">
                            <i class="icofont icofont-file-document"></i>Personal Details
                        </a>
                    </li>
                    {{-- OTP's Lists --}}
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-otp-tab" data-bs-toggle="pill" href="#pills-warning-otp" role="tab" aria-controls="pills-warning-otp" aria-selected="false" data-bs-original-title="" title="">
                            <i class="icofont icofont-ui-cell-phone"></i>OTP
                        </a>
                    </li>
                    {{-- Steps --}}
                    <li class="nav-item">
                        <a class="nav-link" id="pills-warning-step-tab" data-bs-toggle="pill" href="#pills-warning-step" role="tab" aria-controls="pills-warning-step" aria-selected="false" data-bs-original-title="" title="">
                            <i class="icofont icofont-comment"></i>Steps
                        </a>
                    </li>
                    {{-- Source Entry --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" id="pills-warning-source-entry-tab" data-bs-toggle="pill" href="#pills-warning-source-entry" role="tab" aria-controls="pills-warning-source-entry" aria-selected="false" data-bs-original-title="" title="">
                            <i class="icofont icofont-space-shuttle"></i>Source Entry
                        </a>
                    </li> --}}
                </ul>
                <div class="tab-content" id="pills-warning-tabContent">
                    <div class="tab-pane fade show active" id="pills-warning-details" role="tabpanel" aria-labelledby="pills-warning-details-tab">
                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Lead Date :</th>
                                                <td>{{ date('d-m-Y h:i:s',strtotime($details->created_at)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Name :</th>
                                                <td>{{ $details->first_name.' '.$details->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Mobile :</th>
                                                <td>{{ $details->mobile_no }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email Id :</th>
                                                <td>{{ $details->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>City</th>
                                                <td>{{ $details->city ?? "N/A" }}</td>
                                            </tr>
                                            <tr>
                                                <th>State</th>
                                                <td>{{ $details->state ?? "N/A" }}</td>
                                            </tr>
                                            <tr>
                                                <th>Pincode</th>
                                                <td>{{ $details->pincode ?? "N/A" }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-personal-details" role="tabpanel" aria-labelledby="pills-personal-details-tab">
                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Gender</th>
                                                <td>
                                                    {{ match(optional($details->personalDetails)->gender) {
                                                        1 => 'Male',
                                                        2 => 'Female',
                                                        default => 'Other'
                                                    } }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Age</th>
                                                <td>{{ optional($details->personalDetails)->age }}</td>
                                            </tr>
                                            <tr>
                                                <th>Height</th>
                                                <td>{{ optional($details->personalDetails)->height ? optional($details->personalDetails)->height . ' cm' : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Weight</th>
                                                <td>{{ optional($details->personalDetails)->weight ? optional($details->personalDetails)->weight . ' kg' : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Medical Issues</th>
                                                <td>
                                                    @if(optional($details->personalDetails)->medical_issue == null)
                                                    N/A
                                                    @else
                                                    @foreach((json_decode($details->personalDetails->medical_issue,true)) as $key => $value)
                                                    <span class="badge badge-warning">{{ $value }}</span>
                                                    @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Activity Level</th>
                                                <td>@switch(optional($details->personalDetails)->active_rate)
                                                    @case(1) Lightly active @break
                                                    @case(2) Moderately active @break
                                                    @case(3) Very active @break
                                                    @default Little or no activity
                                                    @endswitch</td>
                                            </tr>
                                            <tr>
                                                <th>Contact Date Time</th>
                                                <td>{{ (optional($details->personalDetails)->preferred_datetime) ? date('d-m-Y h:i A', strtotime($details->personalDetails->preferred_datetime)) : 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-warning-otp" role="tabpanel" aria-labelledby="pills-warning-otp-tab">
                        <div class="row mt-5">
                            <div class="table-responsive">
                                <table class="table table-bordered otps-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Date</th>
                                            <th>Mobile</th>
                                            <th>OTP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($otps as $otp)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d-m-Y',strtotime($otp->rec_date)) }}</td>
                                            <td>{{ $otp->mobile }}</td>
                                            <td>{{ $otp->otp_code }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-warning-step" role="tabpanel" aria-labelledby="pills-warning-step-tab">
                        <div class="row mt-5">
                            <div class="col-md-8">
                                <div class="vertical-scroll scroll-demo scroll-b-none">
                                    <ol class="list-group list-group-numbered scroll-rtl">
                                        <li class="list-group-item d-flex align-items-start flex-wrap">
                                            <div class="ms-2 me-auto">Basic Details</div>
                                            <span class="badge bg-success text-white rounded-pill p-2">Completed</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-start flex-wrap">
                                            <div class="ms-2 me-auto">Personal Details</div>
                                            @if($details->process_step === 1)
                                            <span class="badge bg-warning text-white rounded-pill p-2">Current</span>
                                            @elseif($details->process_step >= 2)
                                            <span class="badge bg-success text-white rounded-pill p-2">Completed</span>
                                            @else
                                            <span class="badge bg-danger text-white rounded-pill p-2">Pending</span>
                                            @endif
                                        </li>
                                        <li class="list-group-item d-flex align-items-start flex-wrap">
                                            <div class="ms-2 me-auto">Health Details</div>
                                            @if($details->process_step === 2)
                                            <span class="badge bg-warning text-white rounded-pill p-2">Current</span>
                                            @elseif($details->process_step >= 3)
                                            <span class="badge bg-success text-white rounded-pill p-2">Completed</span>
                                            @else
                                            <span class="badge bg-danger text-white rounded-pill p-2">Pending</span>
                                            @endif
                                        </li>
                                        <li class="list-group-item d-flex align-items-start flex-wrap">
                                            <div class="ms-2 me-auto">BMI Report</div>
                                            @if($details->process_step === 3)
                                            <span class="badge bg-warning text-white rounded-pill p-2">Current</span>
                                            @elseif($details->process_step >= 4)
                                            <span class="badge bg-success text-white rounded-pill p-2">Completed</span>
                                            @else
                                            <span class="badge bg-danger text-white rounded-pill p-2">Pending</span>
                                            @endif
                                        </li>
                                        <li class="list-group-item d-flex align-items-start flex-wrap">
                                            <div class="ms-2 me-auto">Payment</div>
                                            @if($details->process_step === 4)
                                            <span class="badge bg-warning text-white rounded-pill p-2">Current</span>
                                            @elseif($details->process_step >= 5)
                                            <span class="badge bg-success text-white rounded-pill p-2">Completed</span>
                                            @else
                                            <span class="badge bg-danger text-white rounded-pill p-2">Pending</span>
                                            @endif
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="tab-pane fade" id="pills-warning-source-entry" role="tabpanel" aria-labelledby="pills-warning-source-entry-tab">
                        <div class="row mt-5">
                            <div class="table-responsive">
                                <table class="table table-bordered source-utm-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Source</th>
                                            <th>Campaign</th>
                                            <th>Medium</th>
                                            <th>Source ID</th>
                                            <th>Referral</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sourceEntry as $entry)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                    <td>{{ $entry->utm_source ?? '-' }}</td>
                    <td>{{ $entry->utm_campaign ?? '-' }}</td>
                    <td>{{ $entry->utm_medium ?? '-' }}</td>
                    <td>{{ $entry->source_id ?? '-' }}</td>
                    <td>{{ $entry->utm_referral ?? '-' }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-outline-success" type="button" id="convert-customer" data-userid="{{$details->id}}">Convert To Customer</button>
    @if($details->is_dnd === 0)
    <button class="btn btn-outline-warning" id="stop-remarketing" data-userid="{{$details->id}}" type="button">Stop Remarketing</button>
    @endif
    @if($details->is_active === 1)
    <button class="btn btn-outline-danger" id="block-customer" data-userid="{{$details->id}}" type="button">Block Customer</button>
    @endif
    <button class="btn btn-outline-danger" id="delete-customer" data-userid="{{$details->id}}" type="button">Delete Customer</button>
</div>
</div>
</div>
</div>
<div class="modal fade" id="convertCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true" style="backdrop-filter: brightness(0.7) blur(2px);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-normal" id="exampleModalLabel1">Convert To Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('manage.weight-loss-program.leads.convertcustomer') }}" class="convert-customer-form" id="convert-customer-form">
                <input type="hidden" name="user_id" id="user_id" value="{{ $details->id }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="regdate">Registration Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="regdate" id="regdate" value="{{ date('Y-m-d',strtotime($details->created_at)) }}">
                            @component('components.ajax-error',['field'=>'regdate'])@endcomponent
                        </div>
                        <div class="col-md-12">
                            <label for="amount">Amount<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="amount" id="amount">
                            <em><strong>Note:</strong> 18% GST amount added on card amount.</em>
                            @component('components.ajax-error',['field'=>'amount'])@endcomponent
                        </div>
                        <div class="col-md-12">
                            <label for="paymentid">Payment Id<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="paymentid" id="paymentid" value="cash_{{ random_code(13) }}">
                            @component('components.ajax-error',['field'=>'paymentid'])@endcomponent
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Create An Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        var table1 = $('.otps-table').DataTable({
            responsive: true
            , searching: false
            , pageLength: 50
            , lengthChange: false
        });
        // var table2 = $('.source-utm-table').DataTable({
        //     responsive: true,
        //     searching: false,
        //     pageLength: 50,
        //     lengthChange: false
        // });
        /* block customer */
        $("#block-customer").on('click', function() {
            swal({
                title: "Are you sure ?"
                , text: "Once the user is block you can`t unblock it again."
                , icon: "warning"
                , buttons: true
                , dangerMode: true
                , buttons: ["Cancel", "Confirm"]
            , }).then((willBlock) => {
                if (willBlock) {
                    let userId = $(this).data('userid');
                    $.ajax({
                        url: '{!! route("manage.weight-loss-program.leads.block.user")  !!}'
                        , type: 'POST'
                        , data: JSON.stringify({
                            id: userId
                        })
                        , contentType: "application/json"
                        , headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        , success: function(result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                $("#infoModals").modal('hide');
                            } else {
                                toastr.success(result.message);
                            }
                        }
                    });
                }
            });
        })
        /* Stop Remarketing */
        $("#stop-remarketing").on('click', function() {
            swal({
                title: "Are you sure ?"
                , text: "Once the user is set to DND, then can`t change further"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
                , buttons: ["Cancel", "Confirm"]
            , }).then((willDND) => {
                if (willDND) {
                    let userId = $(this).data('userid');
                    $.ajax({
                        url: '{!! route("manage.weight-loss-program.leads.dnd.user")  !!}'
                        , type: 'POST'
                        , data: JSON.stringify({
                            id: userId
                        })
                        , contentType: "application/json"
                        , headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        , success: function(result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                $("#infoModals").modal('hide');
                            } else {
                                toastr.success(result.message);
                            }
                        }
                    });
                }
            });
        })
        /* delete user */
        $("#delete-customer").on('click', function() {
            swal({
                title: "Are you sure ?"
                , text: "Once the user is delete, than never get back."
                , icon: "warning"
                , buttons: true
                , dangerMode: true
                , buttons: ["Cancel", "Confirm"]
            , }).then((willDelete) => {
                if (willDelete) {
                    let userId = $(this).data('userid');
                    $.ajax({
                        url: '{!! route("manage.weight-loss-program.leads.destroy.user")  !!}'
                        , type: 'POST'
                        , data: JSON.stringify({
                            id: userId
                        })
                        , contentType: "application/json"
                        , headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        , success: function(result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                $("#infoModals").modal('hide');
                                $("#WLPLeadsTable").DataTable().ajax.reload();
                            } else {
                                toastr.error(result.message);
                            }
                        }
                    });
                }
            });
        })
        /* convert to customer */
        $("#convert-customer").on('click', function() {
            $("#convertCustomerModal").modal('show');
        })
        $('.numeric-input').on('keydown', function(event) {
            if (!(event.key === 'Backspace' || event.key === 'Delete' || (event.key >= '0' && event.key <= '9'))) {
                event.preventDefault();
            }
        });
    })
    $('.convert-customer-form').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var data = new FormData(this);
            $.ajax({
                url: $(this).attr("action")
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , type: 'POST'
                , data: data
                , processData: false
                , contentType: false
                , success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#convertCustomerModal').modal('hide');
                        $('#infoModals').modal('hide');
                        $('#WLPLeadsTable').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                    }
                }
                , error: function(error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors
                        , errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                }
            });
        }
    });

</script>
