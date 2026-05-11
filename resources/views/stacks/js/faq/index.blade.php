<script>
    function openAddModal() {
        $.ajax({
            url: "{{ route('manage.faq.create') }}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addFaqsModal').html(result);
                $('#addFaqModal').modal('show');
            }
        });
    }

    function openEditModal(id) {
        var edit_url = "{{ route('manage.faq.edit', ':id') }}";
        edit_url = edit_url.replace(':id', id);
        $.ajax({
            url: edit_url,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addFaqsModal').html(result);
                $('#editFaqModal').modal('show');
            }
        });
    }

    function deleteFaq(id) {
        swal({
            title: "Are you sure?",
            text: "You want to delete this Faq.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                var delete_url = "{{ route('manage.faq.destroy', ':id') }}";
                delete_url = delete_url.replace(':id', id);
                $.ajax({
                    url: delete_url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        if (result.type === 'success') {
                            toastr.success(result.message);
                            $('#faq-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }

</script>