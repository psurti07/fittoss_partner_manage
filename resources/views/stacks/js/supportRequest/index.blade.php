<script>
    function openDetailsModal(id) {
        var show_url = "{{ route('manage.supportrequest.show', ':id') }}";
        show_url = show_url.replace(':id', id);

        $.ajax({
            url: show_url,
            type: 'GET',
            dataType: 'html',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addSupportRequestModal').html(result);
                $('#SupportRequestModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching support request details:", error);
                alert("Failed to load details. Please try again.");
            }
        });
    }
</script>
