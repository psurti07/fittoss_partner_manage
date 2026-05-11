<div class="modal fade" id="showLeaveUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLeaveModals" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeaveModals">Leave Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('manage.apply-leave.update', $leave->id) }}" class="edit-leave-form" id="edit-leave-form" method="post">
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="name">Name<span class="text-danger">*</span></label>
                                <input type="text" readonly class="form-control" id="name" name="name" value="{{ $leave->name }}">
                                @component('components.ajax-error', ['field' => 'name'])@endcomponent
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="department">Department<span class="text-danger">*</span></label>
                                <input type="text" readonly class="form-control" id="department" name="department" value="{{ $leave->department }}">
                                @component('components.ajax-error', ['field' => 'department'])@endcomponent
                            </div>

                            @php
                            $fixedLeaves = ['Personal Leave','Medical Emergency','Time of without Pay','Bereavement'];
                            $isOther = !in_array($leave->leave_type, $fixedLeaves);
                            @endphp

                            <div class="form-group mb-3">
                                <label for="leave_type">Leave Type<span class="text-danger">*</span></label>
                                <select class="form-select" id="leave_type" name="leave_type">
                                    <option value="">Select a Leave Type</option>
                                    <option value="Personal Leave" {{ $leave->leave_type == 'Personal Leave' ? 'selected' : '' }}>Personal Leave</option>
                                    <option value="Medical Emergency" {{ $leave->leave_type == 'Medical Emergency' ? 'selected' : '' }}>Medical Emergency</option>
                                    <option value="Time of without Pay" {{ $leave->leave_type == 'Time of without Pay' ? 'selected' : '' }}>Time of without Pay</option>
                                    <option value="Bereavement" {{ $leave->leave_type == 'Bereavement' ? 'selected' : '' }}>Bereavement</option>
                                    <option value="Others" {{ $isOther ? 'selected' : '' }}>Others</option>
                                </select>
                                @component('components.ajax-error', ['field' => 'leave_type'])@endcomponent
                            </div>

                            <div class="form-group mb-3" id="other_reason_div" style="{{ $isOther ? '' : 'display:none;' }}">
                                <label for="other_reason">Please specify</label>
                                <input type="text" class="form-control" id="other_reason" name="other_reason"
                                    value="{{ $isOther ? $leave->leave_type : '' }}"
                                    placeholder="Specify other leave reason">
                                @component('components.ajax-error', ['field' => 'other_reason'])@endcomponent
                            </div>

                            <div class="form-group mb-3">
                                <label for="from_date">Note :<span class="text-danger">&nbsp;You must seek approval for leave other than medical emergency leave, 2 days prior to your first day of absence.</span></label>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="from_date">From :<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="from_date" name="from_date" value="{{ $leave->from_date }}">
                                @component('components.ajax-error', ['field' => 'from_date'])@endcomponent
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="to_date">To :<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="to_date" name="to_date" value="{{ $leave->to_date }}">
                                @component('components.ajax-error', ['field' => 'to_date'])@endcomponent
                            </div>

                            @if (false)
                            <div class="form-group col-md-6 mb-3" id="half_day_div" style="{{ $leave->from_date && $leave->to_date ? '' : 'display:none;' }}">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="half_day" name="half_day" {{ $leave->half_day ? 'checked' : '' }}>
                                    <label class="form-check-label" for="half_day">Half Day</label>
                                </div>
                            </div>

                            <div class="row" id="time_fields" style="{{ $leave->half_day ? '' : 'display:none;' }}">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="from_time">From Time</label>
                                    <input type="datetime-local" class="form-control" id="from_time" name="from_time" value="{{ $leave->from_time }}">
                                    @component('components.ajax-error', ['field' => 'from_time'])@endcomponent
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label for="to_time">To Time</label>
                                    <input type="datetime-local" class="form-control" id="to_time" name="to_time" value="{{ $leave->to_time }}">
                                    @component('components.ajax-error', ['field' => 'to_time'])@endcomponent
                                </div>
                            </div>
                            @endif

                            <div class="form-group mb-3">
                                <label for="no_of_days">No of Days<span class="text-danger">*</span></label>
                                <input type="text" readonly class="form-control" id="no_of_days" name="no_of_days" value="{{ $leave->no_of_days }}">
                                @component('components.ajax-error', ['field' => 'no_of_days'])@endcomponent
                            </div>

                            <div class="form-group mb-3">
                                <label for="comments">Comments</label>
                                <textarea id="comments" name="comments" class="form-control">{{ $leave->comments }}</textarea>
                                @component('components.ajax-error',['field'=>'comments'])@endcomponent
                            </div>

                        </div>
                    </div>
                    <!-- Removed individual form buttons, will add common buttons below -->
                </form>

                <div class="card">
                    <div class="card-body">
                        <form id="leaveApprovalForm" class="leaveApprovalForm" method="POST" action="{{ route('manage.apply-leave.approve', $leave->id) }}">
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Leave Status</label>
                                <div class="col-sm-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="leave_status" id="statusPending" value="0" {{ isset($approval) && $approval->leave_status == 0 ? 'checked' : (!isset($approval) ? 'checked' : '') }}>
                                        <label class="form-check-label" for="statusPending">Pending</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="leave_status" id="statusApprove" value="1" {{ isset($approval) && $approval->leave_status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusApprove">Approve</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="leave_status" id="statusReject" value="2" {{ isset($approval) && $approval->leave_status == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusReject">Reject</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Leave</label>
                                <div class="col-sm-8">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <input class="form-check-input" type="checkbox" id="leavePaid" name="paid_leave" value="1" {{ isset($approval) && $approval->paid_leave == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0" for="leavePaid">Paid</label>
                                        <input type="text" name="no_of_paid_leaves" id="paidLeaveInput" class="form-control" placeholder="Enter Paid Leaves" style="width: 200px;" min="0" max="{{ $leave->no_of_days }}" value="{{ isset($approval) ? $approval->no_of_paid_leaves : '' }}">
                                    </div>

                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <input class="form-check-input" type="checkbox" id="leaveUnpaid" name="unpaid_leave" value="1" {{ isset($approval) && $approval->unpaid_leave == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0" for="leaveUnpaid">Unpaid</label>
                                        <input type="text" name="no_of_unpaid_leaves" id="unpaidLeaveInput" class="form-control" placeholder="Enter Unpaid Leaves" style="width: 200px;" min="0" max="{{ $leave->no_of_days }}" value="{{ isset($approval) ? $approval->no_of_unpaid_leaves : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Remarks</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="remarks" rows="3" placeholder="Enter remarks...">{{ isset($approval) ? $approval->remarks : '' }}</textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Common modal footer for both forms -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="common-save-btn" class="btn btn-outline-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    // Calculate number of days with optional half-day
    function calculateDays() {
        let fromDate = new Date($('#from_date').val());
        let toDate = new Date($('#to_date').val());

        if (fromDate && toDate && !isNaN(fromDate) && !isNaN(toDate)) {
            let diff = (toDate - fromDate) / (1000 * 60 * 60 * 24) + 1;

            if ($('#half_day').is(':checked')) {
                if (fromDate.getTime() === toDate.getTime()) {
                    diff = 0.5; // single-day half leave
                } else {
                    diff = diff - 0.5; // multi-day leave with half day
                }
            }

            $('#no_of_days').val(diff);
        } else {
            $('#no_of_days').val('');
        }
    }

    // Show/hide half-day checkbox depending on date range
    function toggleHalfDay() {
        let fromDate = $('#from_date').val();
        let toDate = $('#to_date').val();

        if (fromDate && toDate) {
            $('#half_day_div').show();
        } else {
            $('#half_day_div').hide();
            $('#half_day').prop('checked', false);
            $('#time_fields').hide();
        }

        calculateDays();
    }

    // Show/hide time fields based on half-day checkbox
    $('#half_day').change(function() {
        if ($(this).is(':checked')) {
            $('#time_fields').show();
        } else {
            $('#time_fields').hide();
        }
        calculateDays(); // recalc days after checking/unchecking
    });

    // Bind date changes
    $('#from_date, #to_date').change(function() {
        toggleHalfDay();
    });

    // Show textfield if "Others" is selected
    $('#leave_type').change(function() {
        if ($(this).val() === 'Others') {
            $('#other_reason_div').show();
        } else {
            $('#other_reason_div').hide();
            $('#other_reason').val('');
        }
    });

    // Common Save Changes button handler
    $('#common-save-btn').click(function() {
        // Submit edit leave form
        var editForm = $('.edit-leave-form');
        var approvalForm = $('.leaveApprovalForm');
        var editFormData = new FormData(editForm[0]);
        var approvalFormData = new FormData(approvalForm[0]);
        var editSuccess = false;
        var approvalSuccess = false;

        // Disable button and show spinner
        $('#common-save-btn').html('<span class="spinner-border spinner-border-sm"></span> Saving...');
        $('#common-save-btn').attr('disabled', true);

        // Submit edit form via AJAX
        $.ajax({
            url: editForm.attr("action"),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: editFormData,
            processData: false,
            contentType: false,
            success: function(result) {
                if (result.type === 'SUCCESS') {
                    editSuccess = true;
                    // Now submit approval form
                    $.ajax({
                        url: approvalForm.attr("action"),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: approvalFormData,
                        processData: false,
                        contentType: false,
                        success: function(result2) {
                            if (result2.type === 'SUCCESS') {
                                approvalSuccess = true;
                                toastr.success('Leave updated and approval saved successfully');
                                $('#showLeaveUpdate').modal('hide');
                                $('#leaveapplication-table').DataTable().ajax.reload();
                            } else {
                                toastr.error(result2.message);
                                $('#common-save-btn').html('Save Changes');
                                $('#common-save-btn').attr('disabled', false);
                            }
                        },
                        error: function(error2) {
                            if (error2.responseJSON && error2.responseJSON.message) {
                                toastr.error(error2.responseJSON.message);
                            } else if (error2.responseJSON && error2.responseJSON.errors) {
                                let errors = error2.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    toastr.error(value[0]);
                                });
                            } else {
                                toastr.error('An unexpected error occurred.');
                            }
                            $('#common-save-btn').html('Save Changes');
                            $('#common-save-btn').attr('disabled', false);
                        }
                    });
                } else {
                    toastr.error(result.message);
                    $('#common-save-btn').html('Save Changes');
                    $('#common-save-btn').attr('disabled', false);
                }
            },
            error: function(error) {
                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key).html('<strong>' + value[0] + '</strong>');
                        toastr.error(value[0]);
                    });
                } else if (error.responseJSON && error.responseJSON.message) {
                    toastr.error(error.responseJSON.message);
                } else {
                    toastr.error('An unexpected error occurred.');
                }
                $('#common-save-btn').html('Save Changes');
                $('#common-save-btn').attr('disabled', false);
            }
        });
    });

    $(document).ready(function() {
        $("#paidLeaveInput, #unpaidLeaveInput").on("input", function() {
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    });
</script>