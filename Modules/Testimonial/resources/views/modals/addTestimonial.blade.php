<div class="modal fade" id="addTestimonialModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTestimonialModalLabel">Add Testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addTestimonialForm" action="{{ route('manage.testimonial.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="form-group">
                            <label for="type">Type<span class="txt-danger">*</span></label>
                            <div class="d-flex gap-3 align-items-center mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type1" value="1" required>
                                    <label class="form-check-label" for="type1">Webinar</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type2" value="2">
                                    <label class="form-check-label" for="type2">Weight Gain</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type3" value="3">
                                    <label class="form-check-label" for="type3">Weight Loss</label>
                                </div>
                            </div>
                            @component('components.ajax-error', ['field' => 'type'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="name">Name<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                            @component('components.ajax-error', ['field' => 'name'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="address">Subtitle<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Subtitle">
                            @component('components.ajax-error', ['field' => 'address'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="rating">Rating<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="rating" name="rating" maxlength="1" minlength="1" step="0.1" placeholder="Rating">
                            @component('components.ajax-error', ['field' => 'rating'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="review">Review<span class="txt-danger">*</span></label>
                            <textarea class="form-control" id="review" name="review" placeholder="Review"></textarea>
                            @component('components.ajax-error', ['field' => 'review'])@endcomponent
                        </div>
                        <div class="form-group">
                            <label for="image">Image<span class="txt-danger">*</span></label>
                            <p class="text-danger">
                                <small>
                                    <br>File types: PNG, JPG, JPEG
                                    <br>Maximum file size: 5 MB
                                </small>
                            </p>
                            <!-- <input type="file" class="form-control" id="image" name="image">
                            @component('components.ajax-error', ['field' => 'image'])@endcomponent -->
                            <div class="input-group mb-3">
                                <input class="form-control image_upload" id="image" name="image" type="file">
                                @component('components.ajax-error', ['field' => 'image'])@endcomponent
                            </div>
                            <div id="image-preview-wrapper" class="row"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveTestimonialBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('stacks.js.testimonial.index')
<script>
    $('.image_upload').on('change', function() {
        var previewWrapper = $('#image-preview-wrapper');

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