<div class="modal fade" id="editDiseaseModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editDiseaseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDiseaseModalLabel">Edit Disease</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDiseaseForm" action="{{ route('manage.disease.update', $data->id) }}" method="POST">
                <div class="modal-body">
                    @method('PUT')
                    <div class="row g-3">
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        <div class="form-group">
                            <label for="name">Name<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                            @component('components.ajax-error', ['field' => 'name'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description', $data->description) }}</textarea>
                            @component('components.ajax-error', ['field' => 'description'])@endcomponent
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editDiseaseBtn">Update Disease</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#editDiseaseForm').submit(function(event) {
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
                    $('#editDiseaseBtn').html('<span class="spinner-border spinner-border-sm"></span> Update Disease ');
                    $('#editDiseaseBtn').attr('disabled', true);
                },
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'success') {
                        $('#editDiseaseBtn').html('Update Disease');
                        $('#editDiseaseBtn').attr('disabled', false);
                        toastr.success(result.message);

                        $('#editDiseaseModal').modal('hide');
                        $('#diseases-table').DataTable().ajax.reload();
                    } else {
                        $('#editDiseaseBtn').html('Update Disease');
                        $('#editDiseaseBtn').attr('disabled', false);
                        toastr.error(result.message);
                    }
                },
                error: function(error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors,
                        errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#editDiseaseBtn').html('Update Disease');
                    $('#editDiseaseBtn').attr('disabled', false);
                }
            });
        }
    });
</script>