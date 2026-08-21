<div class="modal fade" id="editSms" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit SMS Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manage.sms.smsmessage.updateSmsMessage', ['id' => $data->id]) }}" class="update-sms-form" id="update-sms-form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{$data['id']}}">
                    <div class="row">
                        <div class="form-group col-md-12 mb-3">
                            <ul>
                                <li class="text-info fw-8">Use <code>%26</code> instead of <code>&amp;</code> in the message.</li>
                                <li class="text-info fw-8">Use the exact <code>{bmi}</code> variable to insert BMI.</li>
                                <li class="text-info fw-8">Use the exact <code>{disease}</code> variable to insert Disease.</li>
                                <li class="text-info fw-8">Use the exact <code>{link}</code> variable to insert Process or schedule slot link.</li>
                            </ul>
                            <label>Message <span class="text-danger">*</span></label>
                            <textarea class="form-control input-air-primary" name="message" id="message" rows="5" placeholder="Enter SMS message">{{ $data['message'] }}</textarea>
                            @component('components.ajax-error', ['field' => 'message']) @endcomponent
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="sms-btn" class="btn btn-outline-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.update-sms-form').submit(function(event) {
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
                    $('#sms-btn').html('<span class="spinner-border spinner-border-sm"></span> Update');
                    $('#sms-btn').attr('disabled', true);
                },
                success: function(result) {
                    $('#sms-btn').attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#editSms').modal('hide');
                        $('#smsmessage-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                        $('#sms-btn').html('Update');
                        $('#sms-btn').attr('disabled', false);
                    }
                },
                error: function(error) {
                    $('#sms-btn').attr("disabled", false);
                    let errors = error.responseJSON.errors,
                        errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#sms-btn').html('Update');
                    $('#sms-btn').attr('disabled', false);
                }
            });
        }
    });
</script>
