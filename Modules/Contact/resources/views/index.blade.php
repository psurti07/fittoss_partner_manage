@extends('layouts.manage')
@section('title', 'Contact Inquiry')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush

@push('style-css')

@endpush

@section('breadcrumb-title')
<h3>Contact Inquiry</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Main IVR</li>
    <li class="breadcrumb-item active">Contact Inquiry</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="addContactRequestModal"></div>

@endsection

@push('script-src')
@include('stacks.js.manage.datatables');
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}

<script>
    function openDetailsModal(id) {
        var show_url = "{{ route('manage.contact.show', ':id') }}";
        show_url = show_url.replace(':id', id);

        $.ajax({
            url: show_url,
            type: 'GET',
            dataType: 'html',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addContactRequestModal').html(result);
                $('#ContactRequestModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching support request details:", error);
                alert("Failed to load details. Please try again.");
            }
        });
    }
</script>
@endpush