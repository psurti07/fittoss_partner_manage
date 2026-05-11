<style>
    .invalid-feedback {
        display: block;
        font-weight: 100 !important;
        font-size: 14px !important;
    }
</style>
<div class="modal fade" id="addRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addRoleModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addRoleForm" action="{{ route('manage.role.store') }}" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group">
                            <label for="moduleName">Name<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name">
                            @component('components.ajax-error', ['field' => 'name'])@endcomponent
                        </div>
                        <div class="col-md-12">
                            <label for="permission">Permission<span class="txt-danger">*</span></label>
                            <div class="checkbox-checked">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            @php
                                            $chunkedPermissions = $permissions->chunk(4);
                                            @endphp
                                            @foreach($chunkedPermissions as $chunk)
                                            <tr>
                                                @foreach($chunk as $permission)
                                                <td style="width: 25%; padding: 5px; vertical-align: middle;">
                                                    <div class="input_outer" style="display: flex; align-items: center;">
                                                        <input
                                                            class="form-check-input"
                                                            id="permission_{{ $permission->id }}"
                                                            name="permissions[]"
                                                            type="checkbox"
                                                            value="{{ $permission->id }}"
                                                            style="margin-right: 5px;">
                                                        <label for="permission_{{ $permission->id }}" style="margin: 0;">
                                                            {{ ucfirst($permission->name) }}
                                                        </label>
                                                    </div>
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="invalid-feedback error-msg text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveRoleBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#addRoleForm').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var data = new FormData(this);
            console.log(data, "data");

            $.ajax({
                url: $(this).attr("action"),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#saveRoleBtn').html('<span class="spinner-border spinner-border-sm"></span> Save ');
                    $('#saveRoleBtn').attr('disabled', true);
                },
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'success') {
                        $('#saveRoleBtn').html('Save');
                        $('#saveRoleBtn').attr('disabled', false);
                        $('#addRoleModal').modal('hide');
                        toastr.success(result.message);
                        $('#role-table').DataTable().ajax.reload();
                    } else {
                        $('#saveRoleBtn').html('Save');
                        $('#saveRoleBtn').attr('disabled', false);
                        toastr.error(result.message);
                    }
                },
                error: function(error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors;
                    errorsHtml = '';
                    $.each(errors, function(key, value) {
                        var errorHtml = '<strong>' + value[0] + '</strong>';
                        if (key === 'permissions') {
                            $('.error-msg').html(errorHtml);
                        } else {
                            $('.' + key).html(errorHtml);
                        }
                    });
                    $('#saveRoleBtn').html('Save');
                    $('#saveRoleBtn').attr('disabled', false);
                }
            });
        }
    });
</script>