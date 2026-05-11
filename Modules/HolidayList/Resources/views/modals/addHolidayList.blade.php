<div class="modal fade" id="addHolidayList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Yearly Holiday List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.holiday-list.save')}}" class="save-holiday-list-form" id="save-holiday-list-form" method="post">
                <div class="modal-body">
                    
                    <div class="row">

                        <div class="form-group">
                            <label for="holiday_date">Holiday Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="holiday_date" name="holiday_date" placeholder="Diwali">
                            @component('components.ajax-error', ['field' => 'holiday_date'])@endcomponent
                        </div>
                        <div class="form-group">
                            <label for="holiday_name">Holiday Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="holiday_name" name="holiday_name" placeholder="Enter Holiday Name">
                            @component('components.ajax-error', ['field' => 'holiday_name'])@endcomponent
                        </div>
                        <div class="form-group mb-1">
                            <label for="holiday_type">Holiday Type</label>
                            <select class="form-select" id="holiday_type" name="holiday_type">
                                <option value="">Select a Holiday Type</option>
                                <option value="0">Full Day</option>
                                <option value="1">Half Day</option>
                            </select>
                            @component('components.ajax-error', ['field' => 'holiday_type'])@endcomponent
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="holiday-list-btn" class="btn btn-outline-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.save-holiday-list-form').submit(function(event) {
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
                beforeSend: function() {
                    $('#holiday-list-btn').html('<span class="spinner-border spinner-border-sm"></span> Add');
                    $('#holiday-list-btn').attr('disabled', true);
                },
                success: function(result) {
                    $('#holiday-list-btn').attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#addHolidayList').modal('hide');
                        $('#holidaylist-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                        $('#holiday-list-btn').html('Add');
                        $('#holiday-list-btn').attr('disabled', false);
                    }
                },
                error: function(error) {
                    $('#holiday-list-btn').attr("disabled", false);
                    let errors = error.responseJSON.errors,
                        errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#holiday-list-btn').html('Add');
                    $('#holiday-list-btn').attr('disabled', false);
                }
            });
        }
    });
</script>