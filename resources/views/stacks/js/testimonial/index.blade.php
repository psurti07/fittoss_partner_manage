<script>
    function openAddModal() {
        $.ajax({
            url: "{{ route('manage.testimonial.create') }}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addTestimonialModal').html(result);
                $('#addTestimonialModal').modal('show');
            }
        });
    }

    function openEditModal(id) {
        var edit_url = "{{ route('manage.testimonial.edit', ':id') }}";
        edit_url = edit_url.replace(':id', id);
        $.ajax({
            url: edit_url,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addTestimonialModal').html(result);
                $('#editTestimonialModal').modal('show');
            }
        });
    }

    function deleteTestimonial(id) {
        swal({
            title: "Are you sure?",
            text: "You want to delete this Testimonial.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                var delete_url = "{{ route('manage.testimonial.destroy', ':id') }}";
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
                            $('#testimonial-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }


    $('#addTestimonialForm').on('submit', function(e) {
        e.preventDefault();
        let button = $('#saveTestimonialBtn');
        button.attr("disabled", true);

        let form = $('#addTestimonialForm');
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
                $('#saveTestimonialBtn').html('<span class="spinner-border spinner-border-sm"></span> Save ');
                $('#saveTestimonialBtn').attr('disabled', true);
            },
            success: function(response) {
                button.attr("disabled", false);
                if (response.type === 'success') {
                    $('#saveTestimonialBtn').html('Save');
                    $('#saveTestimonialBtn').attr('disabled', false);
                    $('#addTestimonialModal').modal('hide');
                    toastr.success(response.message);
                    $('#testimonial-table').DataTable().ajax.reload();
                } else {
                    toastr.error(result.message);
                    $('#saveTestimonialBtn').html('Save');
                    $('#saveTestimonialBtn').attr('disabled', false);
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
                $('#saveTestimonialBtn').html('Save');
                $('#saveTestimonialBtn').attr('disabled', false);
            }
        });
    });
</script>