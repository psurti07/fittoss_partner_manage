<div class="modal fade" id="editTestimonialModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTestimonialModalLabel">Edit Testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTestimonialForm" action="{{ route('manage.testimonial.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @method('PUT')
                    <div class="row g-3">
                        <input type="hidden" name="id" value="{{ $data['id'] }}">

                        <div class="form-group">
                            <label for="type">Type<span class="txt-danger">*</span></label>
                            <div class="d-flex gap-3 align-items-center mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type1" value="1" {{ $data->type == 1 ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="type1">Webinar</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type2" value="2" {{ $data->type == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type2">Weight Gain</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type3" value="3" {{ $data->type == 3 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type3">Weight Loss</label>
                                </div>
                            </div>
                            @component('components.ajax-error', ['field' => 'type'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="name">Name<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                            @component('components.ajax-error', ['field' => 'name'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="address">Address<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $data->address }}">
                            @component('components.ajax-error', ['field' => 'address'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="rating">Rating<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="rating" name="rating" maxlength="1" minlength="1" step="0.1" value="{{ $data->rating }}">
                            @component('components.ajax-error', ['field' => 'rating'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="review">Review<span class="txt-danger">*</span></label>
                            <textarea class="form-control" id="review" name="review">{{ $data->review }}</textarea>
                            @component('components.ajax-error', ['field' => 'review'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            @if($data->image)
                            <div id="testimonial_img">
                                <img src="{{ asset($data->image) }}" alt="Testimonial Image" style="max-width: 200px; max-height: 200px;">
                            </div>
                            @endif
                            <input class="form-control image_upload mt-3" id="image" name="image" type="file">
                            @component('components.ajax-error', ['field' => 'image'])@endcomponent
                            <div id="image-preview-wrapper" class="row"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editTestimonialBtn">Update Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#editTestimonialForm').submit(function(event) {
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
                    $('#editTestimonialBtn').html('<span class="spinner-border spinner-border-sm"></span> Update Testimonial ');
                    $('#editTestimonialBtn').attr('disabled', true);
                },
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'success') {
                        $('#editTestimonialBtn').html('Update Testimonial');
                        $('#editTestimonialBtn').attr('disabled', false);
                        toastr.success(result.message);
                        $('#editTestimonialModal').modal('hide');
                        $('#testimonial-table').DataTable().ajax.reload();
                    } else {
                        $('#editTestimonialBtn').html('Update Testimonial');
                        $('#editTestimonialBtn').attr('disabled', false);
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
                    $('#editTestimonialBtn').html('Update Testimonial');
                    $('#editTestimonialBtn').attr('disabled', false);
                }
            });
        }
    });

    $('.image_upload').on('change', function() {
        var previewWrapper = $('#image-preview-wrapper');
        var prev_img = $('#testimonial_img');
        prev_img.empty();
        previewWrapper.empty();
        var files = this.files;
        if (files.length > 0) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function(e) {
                    var image = $('<img>').attr('src', e.target.result).css({
                        'width': '100px',
                        'height': '100px',
                        'margin': '5px',
                        'object-fit': 'cover',
                        'border': '1px solid #ddd',
                        'padding': '4px',
                        'border-radius': '4px'
                    });
                    previewWrapper.append(image);
                };

                reader.readAsDataURL(file);
            }
        }
    });
    $(document).ready(function () {
        $("#rating").on("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    });
</script>