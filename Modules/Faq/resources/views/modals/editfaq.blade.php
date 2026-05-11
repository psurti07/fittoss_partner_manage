<div class="modal fade" id="editFaqModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFaqModalLabel">Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editFaqForm" action="{{ route('manage.faq.update', $data->id) }}" method="POST">
                <div class="modal-body">
                    @method('PUT')
                    <div class="form-group">
                        <label for="question">Question<span class="txt-danger">*</span></label>
                        <input type="text" class="form-control" id="question" name="question" value="{{ $data->question }}">
                        @component('components.ajax-error', ['field' => 'question'])@endcomponent
                    </div>
                    <div class="form-group">
                        <label for="answer">Answer<span class="txt-danger">*</span></label>
                        <input type="text" class="form-control" id="answer" name="answer" value="{{ $data->answer }}">
                        @component('components.ajax-error', ['field' => 'answer'])@endcomponent
                    </div>
                    <div class="form-group">
                        <label for="category">Category<span class="txt-danger">*</span></label>
                        <select class="form-control" id="category" name="category">
                            <option value="">Select Category</option>
                            @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ $data->category_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @component('components.ajax-error', ['field' => 'category'])@endcomponent
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editFaqBtn">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#editFaqForm').submit(function(event) {
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
                    $('#editFaqBtn').html('<span class="spinner-border spinner-border-sm"></span> Update FAQ ');
                    $('#editFaqBtn').attr('disabled', true);
                },
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'success') {
                        $('#editFaqBtn').html('Update FAQ');
                        $('#editFaqBtn').attr('disabled', false);
                        toastr.success(result.message);
                        $('#editFaqModal').modal('hide');
                        $('#faq-table').DataTable().ajax.reload();
                    } else {
                        $('#editFaqBtn').html('Update FAQ');
                        $('#editFaqBtn').attr('disabled', false);
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
                    $('#editFaqBtn').html('Update FAQ');
                    $('#editFaqBtn').attr('disabled', false);
                }
            });
        }
    });
</script>