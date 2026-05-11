<script>
    function openAddModal() {
        $.ajax({
            url: "{{ route('manage.disease.create') }}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addDiseaseModal').html(result);
                $('#addDiseaseModal').modal('show');
            }
        });
    }

    function openEditModal(id) {
        var edit_url = "{{ route('manage.disease.edit', ':id') }}";
        edit_url = edit_url.replace(':id', id);
        $.ajax({
            url: edit_url,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addDiseaseModal').html(result);
                $('#editDiseaseModal').modal('show');
            }
        });
    }

    function deleteDisease(id) {
        swal({
            title: "Are you sure?",
            text: "You want to delete this Disease.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                var delete_url = "{{ route('manage.disease.destroy', ':id') }}";
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
                            $('#diseases-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }


    $('#addDiseaseForm').on('submit', function(e) {
        e.preventDefault();
        let button = $('#saveDiseaseBtn');
        button.attr("disabled", true);

        let form = $('#addDiseaseForm');
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
                $('#saveDiseaseBtn').html('<span class="spinner-border spinner-border-sm"></span> Save ');
                $('#saveDiseaseBtn').attr('disabled', true);
            },
            success: function(response) {
                button.attr("disabled", false);
                if (response.type === 'success') {
                    $('#saveDiseaseBtn').html('Save');
                    $('#saveDiseaseBtn').attr('disabled', false);
                    $('#addDiseaseModal').modal('hide');
                    toastr.success(response.message);
                    $('#diseases-table').DataTable().ajax.reload();
                } else {
                    toastr.error(result.message);
                    $('#saveDiseaseBtn').html('Save');
                    $('#saveDiseaseBtn').attr('disabled', false);
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
                $('#saveDiseaseBtn').html('Save');
                $('#saveDiseaseBtn').attr('disabled', false);
            }
        });
    });
</script>