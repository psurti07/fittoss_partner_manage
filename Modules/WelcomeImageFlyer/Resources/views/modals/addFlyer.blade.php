<div class="modal fade" id="addFlyer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Welcome Image Flyer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manage.welcome_image_flyer.save') }}" class="save-flyer-form" id="save-flyer-form"
                method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- <input type="hidden" name="rec_date" value="{{ date('Y-m-d H:i:s') }}"> -->
                    <div class="row">

                        <div class="col-6 form-group">
                            <label for="flyer_img">Flyer Image<span class="txt-danger">*</span></label>
                            <input type="file" class="form-control" id="flyer_img" name="flyer_img"
                                accept="image/png, image/jpeg, image/jpg">

                            @component('components.ajax-error', ['field' => 'flyer_img'])
                            @endcomponent
                        </div>
                        <div class="form-group col-md-6">
                            <img src="https://docutils.sourceforge.io/sandbox/py-rest-doc/sphinx/style/preview.png"
                                width="150px" id="imgpreview" class="mt-3">
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Flyer Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-air-primary" name="flyer_name"
                                id="flyer_name" value="{{ old('flyer_name') }}" placeholder="Welcome Image Flyer Name">
                            @component('components.ajax-error', ['field' => 'flyer_name'])
                            @endcomponent
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="flyer-btn" class="btn btn-outline-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.save-flyer-form').submit(function(event) {
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
                    $('#flyer-btn').html(
                        '<span class="spinner-border spinner-border-sm"></span> Add Flyer');
                    $('#flyer-btn').attr('disabled', true);
                },
                success: function(result) {
                    $('#flyer-btn').attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#addFlyer').modal('hide');
                        $('#welcomeimageflyer-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                        $('#flyer-btn').html('Add');
                        $('#flyer-btn').attr('disabled', false);
                    }
                },
                error: function(error) {
                    $('#flyer-btn').attr("disabled", false);
                    let errors = error.responseJSON.errors,
                        errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#flyer-btn').html('Add');
                    $('#flyer-btn').attr('disabled', false);
                }
            });
        }
    });


    $("#flyer_img").change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#imgpreview').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
