<script>
    function openAddModal() {
        $.ajax({
            url: "{{ route('manage.role.create') }}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addRolesModal').html(result);
                $('#addRoleModal').modal('show');
            }
        });
    }

    function openEditModal(id) {
        var edit_url = "{{ route('manage.role.edit', ':id') }}";
        edit_url = edit_url.replace(':id', id);
        $.ajax({
            url: edit_url,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addRolesModal').html(result);
                $('#editRoleModal').modal('show');
            }
        });
    }

    function deleteRole(id){
        swal({
            title: "Are you sure?",
            text: "You want to delete this Role.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                var delete_url = "{{ route('manage.role.destroy', ':id') }}";
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
                            $('#role-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }
</script>