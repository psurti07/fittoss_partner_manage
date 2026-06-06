@extends('layouts.manage')
@section('title', 'Events')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Events</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Events</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive1">
                        <table class="table-border table-striped table" id="eventsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rec Date</th>
                                    <th>Event Title</th>
                                    <th>Event Date</th>
                                    <th>Amount</th>
                                    <th>Offer Amount</th>
                                    <th>In Offer</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-src')
@include('stacks.js.manage.datatables')
@endpush
@push('script-tag')
@if(Session::has('success'))
<script>
    toastr.success('{{Session::get('success')}}')
</script>
@endif
@if(session('error'))
<script>
    toastr.error('{{Session::get('error')}}')
</script>
@endif
<script>
    $(document).ready(function() {
        $('#eventsTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            lengthMenu: [50, 100, 200],
            ajax: "{{ route('manage.events.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'title', name: 'title' },
                { data: 'date', name: 'date' },
                { data: 'amount', name: 'amount' },
                { data: 'offer_amount', name: 'offer_amount' },
                { data: 'in_offer', name: 'in_offer', orderable: false }
            ]
        });
    });


</script>
@endpush
