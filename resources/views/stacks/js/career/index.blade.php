<script>
    function openAddModal() {
        $.ajax({
            url: "{{ route('manage.career.create') }}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addCareerModal').html(result);
                $('#addCareerModal').modal('show');
            }
        });
    }

    function openEditModal(id) {
        var edit_url = "{{ route('manage.career.edit', ':id') }}";
        edit_url = edit_url.replace(':id', id);
        $.ajax({
            url: edit_url,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addCareerModal').html(result);
                $('#editCareerModal').modal('show');
            }
        });
    }

    function deleteCareer(id) {
        swal({
            title: "Are you sure?",
            text: "You want to delete this Career.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                var delete_url = "{{ route('manage.career.destroy', ':id') }}";
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
                            $('#career-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }


    CKEDITOR.replace('career_content');
    $('#addCareerForm').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var editor = CKEDITOR.instances['career_content'];
            editor.updateElement();
            var data = new FormData(this);
            data.append('career_content', $('#career_content').val());
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
                    $('#saveCareerBtn').html('<span class="spinner-border spinner-border-sm"></span> Save ');
                    $('#saveCareerBtn').attr('disabled', true);
                },
                success: function(result) {
                    // $(this).attr("disabled", false);
                    if (result.type === 'success') {
                        toastr.success(result.message);
                        $('#saveCareerBtn').html('Save');
                        $('#saveCareerBtn').attr('disabled', false);
                        $('#addCareerModal').modal('hide');
                        $('#career-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                        $('#saveCareerBtn').html('Save');
                        $('#saveCareerBtn').attr('disabled', false);
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
                    $('#saveCareerBtn').html('Save');
                    $('#saveCareerBtn').attr('disabled', false);
                }
            });
        }
    });
</script>