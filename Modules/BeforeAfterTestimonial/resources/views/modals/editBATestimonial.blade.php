<div class="modal fade" id="editBeforeAfterTestimonialModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editBeforeAfterTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBeforeAfterTestimonialModalLabel">Edit Before After Testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editBeforeAfterTestimonialForm" action="{{ route('manage.before-after-testimonial.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @method('PUT')
                    <div class="row g-3">
                        <input type="hidden" name="id" value="{{ $data['id'] }}">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service">Service<span class="txt-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="service" id="service1" value="1" {{ $data->service == 1 ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="service1">Weight Gain</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="service" id="service2" value="2" {{ $data->service == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="service2">Weight Loss</label>
                                    </div>
                                </div>
                                @component('components.ajax-error', ['field' => 'service'])@endcomponent
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name<span class="txt-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                                @component('components.ajax-error', ['field' => 'name'])@endcomponent
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title<span class="txt-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $data->title }}">
                                @component('components.ajax-error', ['field' => 'title'])@endcomponent
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $data->description }}</textarea>
                                @component('components.ajax-error', ['field' => 'description'])@endcomponent
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="days">Days<span class="txt-danger">*</span></label>
                                <input type="text" class="form-control" id="days" name="days" maxlength="100" minlength="1" value="{{ $data->days }}">
                                @component('components.ajax-error', ['field' => 'days'])@endcomponent
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rating">Rating<span class="txt-danger">*</span></label>
                                <input type="text" class="form-control" id="rating" name="rating" maxlength="1" minlength="1" step="0.1" value="{{ $data->rating }}">
                                @component('components.ajax-error', ['field' => 'rating'])@endcomponent
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="before_image">Before Image</label>
                                <div id="before_image_preview" class="mt-2">
                                    @if(!empty($data->before_image))
                                    <img src="{{ asset($data->before_image) }}" alt="Before Image" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; padding: 4px; border-radius: 4px;">
                                    @endif
                                </div>
                                <input class="form-control image_upload mt-3" id="before_image" name="before_image" type="file" data-preview="before_image_preview">
                                @component('components.ajax-error', ['field' => 'before_image'])@endcomponent
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="after_image">After Image</label>
                                <div id="after_image_preview" class="mt-2">
                                    @if(!empty($data->after_image))
                                    <img src="{{ asset($data->after_image) }}" alt="After Image" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; padding: 4px; border-radius: 4px;">
                                    @endif
                                </div>
                                <input class="form-control image_upload mt-3" id="after_image" name="after_image" type="file" data-preview="after_image_preview">
                                @component('components.ajax-error', ['field' => 'after_image'])@endcomponent
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editBeforeAfterTestimonialBtn">Update Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#editBeforeAfterTestimonialForm').submit(function(event) {
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
                    $('#editBeforeAfterTestimonialBtn').html('<span class="spinner-border spinner-border-sm"></span> Update Testimonial ');
                    $('#editBeforeAfterTestimonialBtn').attr('disabled', true);
                },
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'success') {
                        $('#editBeforeAfterTestimonialBtn').html('Update Testimonial');
                        $('#editBeforeAfterTestimonialBtn').attr('disabled', false);
                        toastr.success(result.message);
                        $('#editBeforeAfterTestimonialModal').modal('hide');
                        $('#beforeaftertestimonial-table').DataTable().ajax.reload();
                    } else {
                        $('#editBeforeAfterTestimonialBtn').html('Update Testimonial');
                        $('#editBeforeAfterTestimonialBtn').attr('disabled', false);
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
                    $('#editBeforeAfterTestimonialBtn').html('Update Testimonial');
                    $('#editBeforeAfterTestimonialBtn').attr('disabled', false);
                }
            });
        }
    });

    $('.image_upload').on('change', function() {
        var previewId = $(this).data('preview');
        var previewWrapper = $('#' + previewId);
        previewWrapper.empty();

        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var image = $('<img>').attr('src', e.target.result).css({
                    'width': '100px',
                    'height': '100px',
                    'margin-top': '10px',
                    'object-fit': 'cover',
                    'border': '1px solid #ddd',
                    'padding': '4px',
                    'border-radius': '4px'
                });
                previewWrapper.html(image);
            };
            reader.readAsDataURL(file);
        }
    });



    $(document).ready(function() {
        $("#rating").on("input", function() {
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    });
    $(document).ready(function() {
        $("#days").on("input", function() {
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    });
</script>