@extends('layouts.manage')
@section('title', 'Website Links')

@push('css-links')
    @include('stacks.css.manage.datatables')
@endpush
@push('style-css')
@endpush

@section('breadcrumb-title')
<h3>Website Links</h3>
@endsection

@section('breadcrumb')
<div class="row">
    <div class="col-6">
        <h3>Website Links</h3>
    </div>
    <div class="col-6">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('manage.dashboard') }}">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                    </svg>
                </a>
            </li>
            <li class="breadcrumb-item active">Website Links</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-12">
            <div class="d-flex align-items-end">
                <div class="d-flex justify-content-start align-items-end gap-3">
                    <div class="col-md-8 col-12">
                        <label class="form-label">Link Type</label>
                        <select class="form-select" id="link_type">
                            <option value="">All</option>
                            <option value="1">Website</option>
                            <option value="2">Social Media</option>
                            <option value="3">Offer Page</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-outline-warning" id="dateBtn">
                        Show
                    </button>
                </div>
                <div class="ms-auto">
                    <a href="javascript:;" onclick="openAddModal()" class="btn btn-outline-secondary" id="add-website-btn"><i class="fa fa-plus-square"></i>&nbsp;Add Website Links</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="addWebsiteModals"></div>
@endsection

@push('script-src')
    @include('stacks.js.manage.datatables');
@endpush
@push('script-tag')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
<script>
    const table = $("#websitelinks-table");
    table.on('preXhr.dt', function(e, settings, data) {
        data.link_type = $('#link_type').val();
    });
    $('#dateBtn').on('click', function() {
        table.DataTable().ajax.reload();
        return false;
    })
    // OPEN ADD MODAL
    function openAddModal() {
        $.ajax({
            url: "{{ route('manage.website.links.create') }}"
            , type: 'GET'
            , success: function(result) {
                $('.addWebsiteModals').html(result);
                $('#addWebsiteLinks').modal('show');
            }
        });
    }


    // DELETE WEBSITE LINK
    function deleteWebsiteLinks(id) {

        swal({
            title: "Are you sure?"
            , text: "You want to delete this Website Link."
            , icon: "warning"
            , buttons: ["Cancel", "Confirm"]
            , dangerMode: true
        , }).then((willDelete) => {

            if (willDelete) {

                let url = "{{ route('manage.website.links.destroy', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url
                    , type: 'DELETE'
                    , data: {
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(response) {
                        if (response.type === 'SUCCESS') {
                            toastr.success(response.message);
                            $('#websitelinks-table').DataTable().ajax.reload(null, false);
                        }
                    }
                });

            }
        });
    }


    // OPEN EDIT MODAL
    function openEditModal(id) {

        let url = "{{ route('manage.website.links.edit', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            url: url
            , type: 'GET'
            , success: function(result) {
                $('.addWebsiteModals').html(result);
                $('#editWebsiteLinks').modal('show');
            }
        });
    }


    // CHANGE STATUS
    function websiteLinksStatus(id) {

        let url = "{{ route('manage.website.links.changeStatus', ':id') }}";
        url = url.replace(':id', id);

        $.post(url, {
            _token: '{{ csrf_token() }}'
        }, function(response) {

            if (response.type === 'SUCCESS') {
                toastr.success(response.message);
                $('#websitelinks-table').DataTable().ajax.reload(null, false);
            }

        });

    }

    $(document).on('submit', '#addWebsiteLinkForm', function(e){
        e.preventDefault();
        $('.ajax-error').html('');

        let form = this;
        let formData = new FormData(form);
        let btn = $('#saveWebsiteLinkBtn');

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                btn.html('<span class="spinner-border spinner-border-sm"></span> Creating...');
                btn.prop('disabled', true);
            },
            success: function(response){
                if(response.type === 'SUCCESS'){
                    toastr.success(response.message);
                    $('#addWebsiteLinks').modal('hide');

                    if($.fn.DataTable.isDataTable('#websitelinks-table')){
                        $('#websitelinks-table').DataTable().ajax.reload(null,false);
                    }
                    form.reset();
                } else {
                    toastr.error(response.message);
                }
                btn.html('<i class="fa fa-plus"></i> Create Website Link');
                btn.prop('disabled', false);
            },
            error: function(xhr){
                if(xhr.responseJSON && xhr.responseJSON.errors){
                    $.each(xhr.responseJSON.errors, function(key,value){
                        $('.'+key).html(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong');
                }
                btn.html('<i class="fa fa-plus"></i> Create Website Link');
                btn.prop('disabled', false);
            }
        });
    });

    // Auto reset when modal closes
    $(document).on('hidden.bs.modal', '#addWebsiteLinks', function(){
        $('#addWebsiteLinkForm')[0].reset();
        $('.ajax-error').html('');
    });

    /* Edit website link */
    $(document).on('submit', '#editWebsiteLinkForm', function(e){
        e.preventDefault();
        $('.ajax-error').html('');

        let form = this;
        let formData = new FormData(form);
        let btn = $('#updateWebsiteLinkBtn');

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                btn.html('<span class="spinner-border spinner-border-sm"></span> Updating...');
                btn.prop('disabled', true);
            },
            success: function(response){
                if(response.type === 'SUCCESS'){
                    toastr.success(response.message);
                    $('#editWebsiteLinks').modal('hide');
                    $('#websitelinks-table').DataTable().ajax.reload(null,false);
                } else {
                    toastr.error(response.message);
                }
                btn.html('<i class="fa fa-save"></i> Update Website Link');
                btn.prop('disabled', false);
            },
            error: function(xhr){
                if(xhr.responseJSON && xhr.responseJSON.errors){
                    $.each(xhr.responseJSON.errors, function(key,value){
                        $('.'+key).html(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong.');
                }
                btn.html('<i class="fa fa-save"></i> Update Website Link');
                btn.prop('disabled', false);
            }
        });
    });

    // Auto clear errors when modal closes
    $(document).on('hidden.bs.modal', '#editWebsiteLinks', function(){
        $('.ajax-error').html('');
    });
</script>

@endpush
