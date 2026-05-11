<div class="modal fade" id="addFaqModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addFaqModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFaqModalLabel">Add Faq</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addFaqForm" action="{{ route('manage.faq.store') }}" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group">
                            <label for="question">Question<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="question" name="question">
                            @component('components.ajax-error', ['field' => 'question'])@endcomponent
                        </div>
                        <div class="form-group">
                            <label for="moduleName">Answer<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="answer" name="answer">
                            @component('components.ajax-error', ['field' => 'answer'])@endcomponent
                        </div>
                        <div class="form-group">
                            <label for="category">Category<span class="txt-danger">*</span></label>
                            <select class="form-control" id="category" name="category">
                                <option value="">Select Category</option>
                                @foreach($categories as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error', ['field' => 'category'])@endcomponent
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveFaqBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#addFaqForm').submit(function(event) {
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
                    $('#saveFaqBtn').html('<span class="spinner-border spinner-border-sm"></span> Save ');
                    $('#saveFaqBtn').attr('disabled', true);
                },
                success: function(result) {
                    // $(this).attr("disabled", false);
                    if (result.type === 'success') {
                        $('#saveFaqBtn').html('Save');
                        $('#saveFaqBtn').attr('disabled', false);
                        $('#addFaqModal').modal('hide');
                        $('#faq-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                        $('#saveFaqBtn').html('Save');
                        $('#saveFaqBtn').attr('disabled', false);
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
                    $('#saveFaqBtn').html('Save');
                    $('#saveFaqBtn').attr('disabled', false);
                }
            });
        }
    });
</script>