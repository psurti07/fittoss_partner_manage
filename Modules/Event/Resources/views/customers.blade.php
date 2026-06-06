@extends('layouts.manage')
@section('title', 'Customers')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@push('style-css')
<style>
    #customer-table_length {
        margin-left: 25px;
    }

</style>
@endpush

@section('breadcrumb-title')
<h3>Customers</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{!! config('contact.name') !!}</li>
<li class="breadcrumb-item active">Default</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12 text-end d-inline align-content-end">
            <div class="row g-3 d-flex align-items-center">
                <div class="col-md-2 position-relative text-start">
                    <x-event-dropdown />
                </div>
                <div class="col-md-2 position-relative text-start">
                    <label class="form-label" for="fromDate">From Date</label>
                    <input class="form-control" id="fromDate" type="date" name="fromDate" max="{{ date('Y-m-d') }}" value="{{ request('filter') == 'today' ? date('Y-m-d') :date('Y-m-d',strtotime('-10 days')) }}">
                </div>
                <div class="col-md-2 position-relative text-start">
                    <label class="form-label" for="toDate">To Date</label>
                    <input class="form-control" id="toDate" type="date" name="toDate" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-2 position-relative text-start">
                    <button type="button" class="mt-4 btn btn-outline-warning" id="filterBtn">Show</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="eventCustomersTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Event Title</th>
                                    <th>Full Name</th>
                                    <th>Mobile</th>
                                    <th>Email Id</th>
                                    <th>Attend</th>
                                    <th>Enroll</th>
                                    <th class="text-center">Details</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="addModals">
    @include('event::modals.enroll')
</div>

@endsection

@push('script-src')
@include('stacks.js.manage.datatables');

<script type="text/javascript">
    // let today = new Date();
    // let twoDaysBefore = new Date();
    // twoDaysBefore.setDate(today.getDate() - 2);

    // let formatDate = (date) => date.toISOString().split('T')[0]; // Format YYYY-MM-DD

    // let fromDate = sessionStorage.getItem('from_date') || new URLSearchParams(window.location.search).get('from_date') || formatDate(twoDaysBefore);
    // let toDate = sessionStorage.getItem('to_date') || new URLSearchParams(window.location.search).get('to_date') || formatDate(today);

    // $('#fromDate').val(fromDate);
    // $('#toDate').val(toDate);

    // sessionStorage.removeItem('from_date');
    // sessionStorage.removeItem('to_date');

    $(function() {
        var table = $('#eventCustomersTable').DataTable({
            responsive: true
            , processing: true
            , serverSide: true
            , ajax: {
                url: "{{ route('manage.events.customers') }}"
                , data: function(d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                    d.event_id = $('#event_id').val();
                }
            }
            , columns: [{
                    data: 'DT_RowIndex'
                    , name: 'id'
                    , title: '#'
                }
                , {
                    data: 'date'
                    , name: 'date'
                },
                {data: 'event_title', name: 'e.title'}
                , {
                    data: 'fullname'
                    , name: 'fullname'
                }
                , {
                    data: 'mobile_no'
                    , name: 'customers.mobile_no'
                }
                , {
                    data: 'email'
                    , name: 'customers.email'
                },
                {data: 'attend', name: 'attend', orderable: false, searchable: false},
                {data: 'enroll', name: 'enroll', orderable: false, searchable: false}
                , {
                    data: 'action'
                    , name: 'action'
                    , orderable: false
                    , searchable: false
                }
            , ]
            , order: [
                [1, 'desc']
            ]
            , dom: 'Blfrtip'
            , buttons: ['excel', 'csv', 'pdf', 'print']
            , lengthMenu: [
                [100, 250, 500, 1000, -1]
                , [100, 250, 500, 1000, "All"]
            ]
            , pageLength: 100
        , });
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });

    function attended(event_user_id) {
        const url = "{{ route('manage.events.customers.attended') }}";

        swal({
            title: "Are you sure?",
            text: "Mark customer as attended.",
            icon: "info",
            dangerMode: true,
            buttons: ["No", "Yes"]
        }).then((performYes) => {

            if (!performYes) return;

            document.querySelectorAll('.attendBtn').forEach(btn => {
                btn.disabled = true;
            });

            fetch(url, {
                method: 'POST',
                body: JSON.stringify({
                        event_user_id: event_user_id
                      }),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.type === 'SUCCESS') {
                    toastr.success(result.message);
                    $('#eventCustomersTable').DataTable().ajax.reload(null, false);
                } else {
                    toastr.error(result.message);
                }
            })
            .catch(() => {
                toastr.error('Something went wrong.');
            })
            .finally(() => {
                document.querySelectorAll('.attendBtn').forEach(btn => {
                    btn.disabled = false;
                });
            });

        });
    }

    function openEnrollModal(id) {
        document.getElementById('event_user_id').value = id;
        const modal = new bootstrap.Modal(
            document.getElementById('enrollModal')
        );
        modal.show();
    }

    document.getElementById('enrollForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        
        const url = "{{ route('manage.events.customers.enrolled') }}";
        const form = e.target;
        const formData = new FormData(form);
        const btn = document.getElementById('doneBtn');
        btn.disabled = true;

        document.querySelectorAll('.enrollBtn').forEach(btn => {
                btn.disabled = true;
        });

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.status === 422) {
                document.querySelectorAll('.enrollBtn').forEach(btn => {
                    btn.disabled = false;
                });
                btn.disabled = false;
                Object.keys(result.errors).forEach(key => {
                    const field = form.querySelector(`[name="${key}"]`);
                    const errorField = field?.closest(".form-group")?.querySelector(".ajax-error");
                    if (errorField) {
                        errorField.innerHTML = `<span class="text-danger">${result.errors[key][0]}</span>`;
                    }
                });
                return;
            }

            if (result.type === 'SUCCESS') {
                bootstrap.Modal.getInstance(document.getElementById('enrollModal')).hide();
                toastr.success(result.message);
                $('#eventCustomersTable').DataTable().ajax.reload();
            } else {
                toastr.error(result.message);
            }

            document.querySelectorAll('.enrollBtn').forEach(btn => {
                 btn.disabled = false;
            });
            btn.disabled = false;
        } catch (error) {
            toastr.error('Something went wrong.');
            document.querySelectorAll('.enrollBtn').forEach(btn => {
                    btn.disabled = false;
            });
            btn.disabled = false;
        }
    });

</script>
@endpush

@push('script-tag')
@endpush
