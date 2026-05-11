<div class="modal fade addDriveLinkModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="addDriveLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDriveLinkModalLabel">Add Drive Link</h5>
                <button type="button" class="btn-close py-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addDriveLinkForm" action="{{ route('manage.drive.links.store') }}" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group mb-1">
                            <label for="department">Department<span class="text-danger">*</span></label>
                            <select class="form-select" id="department" name="department">
                                <option value="" disabled selected>Select Department</option>
                                @foreach(\App\Models\DriveLinks::DEPARTMENTS as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error', ['field' => 'department'])@endcomponent
                        </div>
                        <div class="form-group">
                            <label for="title">Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Graphic AMC">
                            @component('components.ajax-error', ['field' => 'title'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="link">Link<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="https://drive.google.com/drive/folders/xxxxxx">
                            @component('components.ajax-error', ['field' => 'link'])@endcomponent
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-success" type="submit" id="saveDriveLinkBtn"><i class="fa fa-plus"></i>&nbsp;Create Drive Link</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#addDriveLinkForm').submit(function(event) {

        event.preventDefault();
        $('.ajax-error').html('');

        let form = this;
        let formData = new FormData(form);
        let btn = $('#saveDriveLinkBtn');

        $.ajax({
            url: $(form).attr("action")
            , type: 'POST'
            , data: formData
            , processData: false
            , contentType: false
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            beforeSend: function() {
                btn.html('<span class="spinner-border spinner-border-sm"></span> Creating...');
                btn.prop('disabled', true);
            },

            success: function(result) {

                if (result.type === 'SUCCESS') {

                    toastr.success(result.message);

                    $('.addDriveLinkModal').modal('hide');

                    // Reload page after short delay
                    setTimeout(function() {
                        location.reload();
                    }, 800);

                } else {
                    toastr.error(result.message);
                }

                btn.html('<i class="fa fa-plus"></i> Create Drive Link');
                btn.prop('disabled', false);
            },

            error: function(error) {

                let errors = error.responseJSON.errors;

                $.each(errors, function(key, value) {
                    $('.' + key).html('<strong>' + value[0] + '</strong>');
                });

                btn.html('<i class="fa fa-plus"></i> Create Drive Link');
                btn.prop('disabled', false);
            }
        });

    });

</script>
