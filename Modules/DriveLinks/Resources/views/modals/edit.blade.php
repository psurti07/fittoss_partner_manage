<div class="modal fade editDriveLinkModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editDriveLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDriveLinkModalLabel">Edit Drive Link</h5>
                <button type="button" class="btn-close py-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editDriveLinkForm"
                  action="{{ route('manage.drive.links.update', $drivelinks->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Department -->
                        <div class="form-group mb-1">
                            <label for="department">Department<span class="text-danger">*</span></label>
                            <select class="form-select" name="department">
                                <option value="">Select a Department</option>
                                @foreach(\App\Models\DriveLinks::DEPARTMENTS as $key => $value)
                                    <option value="{{ $key }}" {{ $drivelinks->department == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error', ['field' => 'department'])@endcomponent
                        </div>

                        <!-- Title -->
                        <div class="form-group">
                            <label>Title<span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control"
                                   name="title"
                                   value="{{ $drivelinks->title }}">
                            @component('components.ajax-error', ['field' => 'title'])@endcomponent
                        </div>

                        <!-- Link -->
                        <div class="form-group">
                            <label>Link<span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control"
                                   name="link"
                                   value="{{ $drivelinks->link }}">
                            @component('components.ajax-error', ['field' => 'link'])@endcomponent
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-primary"
                            type="submit"
                            id="updateDriveLinkBtn">
                        <i class="fa fa-save"></i> Update Drive Link
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>

$('#editDriveLinkForm').submit(function (event) {

    event.preventDefault();
    $('.ajax-error').html('');

    let form = this;
    let formData = new FormData(form);
    let btn = $('#updateDriveLinkBtn');

    $.ajax({
        url: $(form).attr("action"),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function(){
            btn.html('<span class="spinner-border spinner-border-sm"></span> Updating...');
            btn.prop('disabled', true);
        },

        success: function (result) {

            if (result.type === 'SUCCESS') {

                toastr.success(result.message);
                $('.editDriveLinkModal').modal('hide');

                // Update card dynamically
                // updateCard(result.data);

            } else {
                toastr.error(result.message);
            }

            btn.html('<i class="fa fa-save"></i> Update Drive Link');
            btn.prop('disabled', false);
        },

        error: function (error) {

            let errors = error.responseJSON.errors;

            $.each(errors, function (key, value) {
                $('.' + key).html('<strong>' + value[0] + '</strong>');
            });

            btn.html('<i class="fa fa-save"></i> Update Drive Link');
            btn.prop('disabled', false);
        }
    });

});

</script>