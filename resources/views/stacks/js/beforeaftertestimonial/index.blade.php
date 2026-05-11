<script>
    function openAddModal() {
        $.ajax({
            url: "{{ route('manage.before-after-testimonial.create') }}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addBeforeAfterTestimonialModal').html(result);
                $('#addBeforeAfterTestimonialModal').modal('show');
            }
        });
    }

    function openEditModal(id) {
        var edit_url = "{{ route('manage.before-after-testimonial.edit', ':id') }}";
        edit_url = edit_url.replace(':id', id);
        $.ajax({
            url: edit_url,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addBeforeAfterTestimonialModal').html(result);
                $('#editBeforeAfterTestimonialModal').modal('show');
                
            }
        });
    }

    function deleteBATestimonial(id) {
        swal({
            title: "Are you sure?",
            text: "You want to delete this Testimonial.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                var delete_url = "{{ route('manage.before-after-testimonial.destroy', ':id') }}";
                delete_url = delete_url.replace(':id', id);
                $.ajax({
                    url: delete_url,
                    type: 'DELETE',
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        if (result.type === 'success') {
                            toastr.success(result.message);
                            $('#beforeaftertestimonial-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }


    $('#addBeforeAfterTestimonialForm').on('submit', function(e) {
        e.preventDefault();
        let button = $('#saveBeforeAfterTestimonialBtn');
        button.attr("disabled", true);

        let form = $('#addBeforeAfterTestimonialForm');
        let formData = new FormData(form[0]);
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#saveBeforeAfterTestimonialBtn').html('<span class="spinner-border spinner-border-sm"></span> Save ');
                $('#saveBeforeAfterTestimonialBtn').attr('disabled', true);
            },
            success: function(response) {
                button.attr("disabled", false);
                if (response.type === 'success') {
                    $('#saveBeforeAfterTestimonialBtn').html('Save');
                    $('#saveBeforeAfterTestimonialBtn').attr('disabled', false);
                    $('#addBeforeAfterTestimonialModal').modal('hide');
                    toastr.success(response.message);
                    $('#beforeaftertestimonial-table').DataTable().ajax.reload();
                } else {
                    toastr.error(result.message);
                    $('#saveBeforeAfterTestimonialBtn').html('Save');
                    $('#saveBeforeAfterTestimonialBtn').attr('disabled', false);
                }
            },
            error: function(response) {
                button.attr("disabled", false);
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $('.invalid-feedback').text('').hide();
                    $.each(errors, function(key, value) {
                        let errorElement = $(`.ajax-error.${key}`);
                        errorElement.text(value[0]).show();
                    });
                }
                $('#saveBeforeAfterTestimonialBtn').html('Save');
                $('#saveBeforeAfterTestimonialBtn').attr('disabled', false);
            }
        });
    });
</script>