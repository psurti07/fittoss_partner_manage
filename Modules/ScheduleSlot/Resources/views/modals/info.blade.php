<div>
    <div class="modal fade" id="scheduleSlotModal" tabindex="-1" aria-labelledby="SupportRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SupportRequestModalLabel">Slot Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0">
                    @php
                    switch ($schedule->status) {
                    case 1:
                    $status = '<p class="mt-2 mb-0 badge-default badge-info text-center text-white">Call Schedule</p>';
                    break;
                    case 2:
                    $status = '<p class="mt-2 mb-0 badge-default badge-success text-center text-white">Call comepleted successfully</p>';
                    break;
                    case 3:
                    $status = '<p class="mt-2 mb-0 badge-default badge-danger text-center text-white">Call schedule cancelled</p>';
                    break;
                    case 4:
                    $status = '<p class="mt-2 mb-0 badge-default badge-warning text-center text-white">Called to customer , but unable to connect</p>';
                    break;
                    default:
                    $status = "-";
                    break;
                    }
                    @endphp
                    {!! $status !!}
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"> Request Date:&nbsp;<b> {{ $schedule->updated_at }}</b></li>
                                        <li class="list-group-item"> Full Name:&nbsp;<b> {{ $schedule->fullName }}</b></li>
                                        <li class="list-group-item"> Mobile :&nbsp;<b>{{ $schedule->mobile_no }}</b></li>
                                        <li class="list-group-item"> Email :&nbsp;<b>{{ $schedule->email }}</b></li>
                                        <li class="list-group-item"> Product Name :&nbsp;<b>{{ $schedule->product_title }}</b></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"> Date:&nbsp;<b> {{ \Carbon\Carbon::parse($schedule->date)->format('Y-m-d') }}</b></li>
                                        <li class="list-group-item"> Time:&nbsp;<b> {{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}</b></li>
                                        <li class="list-group-item"> Language :&nbsp;<b>{{ $schedule->language_text }}</b></li>
                                        <li class="list-group-item"> Remarks :&nbsp;<b>{{ $schedule->remarks }}</b></li>
                                    </ul>
                                    <form method="post" action="{{ route('manage.schedule-slot.update') }}" id="submitForm" class="form-horizontal">
                                        @csrf
                                        <div class="btn-group mb-3 mt-3 d-flex gap-2">
                                            <label class="form-label">Status:</label>
                                            <select class="form-select" name="status" id="status">
                                                @foreach(App\Models\ScheduleSlot::getStatuses() as $key => $value)
                                                <option value="{{ $key }}" {{ $schedule->status == $key ? "selected" :"" }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="row g-2">
                                            <div class="col-12">
                                                <input type="hidden" name="id" id="id" value="{{ $schedule->id }}">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks" aria-describedby="button-addon6"></textarea>
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
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" id="add-remarks" class="btn btn-outline-success">Update</button>
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
    $('#submitForm').submit(function(event) {
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
                , beforeSend: function() {
                    $('#add-remarks').html('<span class="spinner-border spinner-border-sm"></span> Updating...');
                    $('#add-remarks').attr('disabled', true);
                }
                , success: function(result) {
                    $('#add-remarks').html("Update");
                    $('#add-remarks').attr('disabled', false);

                    if (result.type === 'SUCCESS') {
                        $('#submitForm')[0].reset();
                        toastr.success(result.message);
                        window.location.reload();
                    } else {
                        toastr.error(result.message);
                    }
                }
                , error: function(error) {
                    $('#add-remarks').html("Update");
                    $('#add-remarks').attr('disabled', false);

                    let errors = error.responseJSON.errors
                        , errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    toastr.error('Failed to add remarks.');
                }
            });
        }
    });

</script>
