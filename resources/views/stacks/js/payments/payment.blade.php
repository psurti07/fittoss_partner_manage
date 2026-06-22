<script type="text/javascript">
    var ajaxUrls = {
        'manage.payu-log': '{{ route("manage.payu-log") }}',
        'manage.sabpaisa-log': '{{ route("manage.sabpaisa-log") }}',
        'manage.paytm-log': '{{ route("manage.paytm-log") }}',
        'manage.phonepay-log': '{{ route("manage.phonepay-log") }}',
        'manage.vegaah-log': '{{ route("manage.vegaah-log") }}',
        'manage.paygic-log': '{{ route("manage.paygic-log") }}',
        'manage.ccavenue-log': '{{ route("manage.ccavenue-log") }}',
        'manage.cipherpaylog': '{{ route("manage.cipherpaylog") }}',
        'manage.lyralog': '{{ route("manage.lyralog") }}'
    };

    $(function() {
        var table = $('.get-data-table').DataTable({
            scrollX: false,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 50,
            lengthMenu: [50, 100, 200, 250],
            ajax: {
                url: ajaxUrls[currentRouteName] || '{{ route("manage.payu-log") }}',
                data: function(d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                }
            },
            columns: [
                // {
                //     data: 'id',
                //     name: 'id',
                //     title: 'Id'
                // },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    title: '#',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'rec_date',
                    name: 'p.rec_date',
                    title: 'Rec Date',
                    searchable: false,
                },
                {
                    data: 'entry_for',
                    name: 'p.entry_for',
                    title: 'Entry For',
                    searchable: false,
                },
                {
                    data: 'fullname',
                    name: 'c.first_name',
                    title: 'Full Name',
                    searchable: false,
                },
                {
                    data: 'mobile',
                    name: 'c.mobile_no',
                    title: 'Mobile',
                    searchable: false,
                },
                {
                    data: 'email',
                    name: 'c.email',
                    title: 'Email',
                    searchable: false,
                },
                {
                    data: 'order_id',
                    name: 'order_id',
                    title: 'Order Id',
                    searchable: false,
                },
                {
                    data: 'grand_amount',
                    name: 'p.grand_amount',
                    title: 'Grand Amount',
                    searchable: false
                },
                {
                    data: 'order_note',
                    name: 'p.order_note',
                    title: 'Order Note',
                    searchable: false
                },
                {
                    data: 'tx_status',
                    name: 'p.tx_status',
                    title: 'Status',
                    searchable: false,
                    render: function(data, type, row) {
                        return data ? data : '-';
                    }
                },
            ],
            order: [
                [1, 'desc']
            ],
            dom: 'Blfrtip',
            buttons: ['excel', 'csv', 'pdf', 'print']
        });
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });
</script>