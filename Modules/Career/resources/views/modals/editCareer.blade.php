<div class="modal fade" id="editCareerModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editCareerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCareerModalLabel">Edit Career</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCareerForm" action="{{ route('manage.career.update', $data->id) }}" method="POST">
                <div class="modal-body">
                    @method('PUT')
                    <div class="row g-3">
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        <div class="form-group">
                            <label for="title">Title<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $data->title }}">
                            @component('components.ajax-error', ['field' => 'name'])@endcomponent
                        </div>

                        <div class="col-12 form-group">
                            <label for="career_content">Description<span class="text-danger">*</span></label>
                            <textarea id="career_content" name="description" cols="10" rows="5" class="">{{ $data->description}}</textarea>
                            @component('components.ajax-error', ['field' => 'career_content'])@endcomponent
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editCareerBtn">Update Career</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace('career_content');
    $('#editCareerForm').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var editor = CKEDITOR.instances['career_content'];
            editor.updateElement();
            var data = new FormData(this);
            data.append('career_content', $('#career_content').val());
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
                    $('#editCareerBtn').html('<span class="spinner-border spinner-border-sm"></span> Update Career ');
                    $('#editCareerBtn').attr('disabled', true);
                },
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'success') {
                        $('#editCareerBtn').html('Update Career');
                        $('#editCareerBtn').attr('disabled', false);
                        toastr.success(result.message);
                        $('#editCareerModal').modal('hide');
                        $('#career-table').DataTable().ajax.reload();
                    } else {
                        $('#editCareerBtn').html('Update Career');
                        $('#editCareerBtn').attr('disabled', false);
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
                    $('#editCareerBtn').html('Update Career');
                    $('#editCareerBtn').attr('disabled', false);
                }
            });
        }
    });
</script>