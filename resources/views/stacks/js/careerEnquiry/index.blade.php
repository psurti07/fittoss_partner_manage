<script>
    function deleteCareerEnquiry(id) {
        swal({
            title: "Are you sure?",
            text: "You want to delete this Career Enquiry.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then((willDelete) => {
            if (willDelete) {
                var delete_url = "{{ route('manage.careerenquiry.destroy', ':id') }}";
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
                            $('#careerenquiry-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        });
    }
</script>