@extends('layouts.manage')
@section('title', 'Remarketing Schedules')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Remarketing Schedules</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Remarketing Schedules</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        {{-- <div class="col-12">
            <div class="row g-3 d-flex align-items-center mb-3">
                <a href="{{ route('manage.remarketing.schedule.create') }}" class="btn btn-outline-info">
                    Add <i class="fa fa-plus-square"></i>
                </a>
            </div>
        </div> --}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive1">
                        <table class="table-border table-striped table" id="productsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Title</th>
                                    <th>Action</th>
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
        var table = $('#productsTable').DataTable({
            processing: true
            , serverSide: true
            , pageLength: 50
            , lengthMenu: [50, 100, 200]
            , ajax: {
                url: "{{ route('manage.remarketing.schedule.index') }}",
                data: function (d) {
                }
            }
            , columns: [{
                    data: 'DT_RowIndex'
                    , name: 'DT_RowIndex'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'product_title'
                    , name: 'p.product_title'
                }
                , {
                    data: 'action'
                    , name: 'action'
                    , orderable: false
                    , searchable: false
                }
            ]
        });
    });

</script>
@endpush
