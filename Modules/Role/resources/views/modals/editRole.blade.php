<div class="modal fade" id="editRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editRoleModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editRoleForm" action="{{ route('manage.role.update',$role->id) }}" method="POST">
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group">
                            <label for="name">Name<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$role->name) }}">
                            @component('components.ajax-error', ['field' => 'name'])@endcomponent
                        </div>
                        <div class="col-md-12">
                            <label for="permission">Permission</label>
                            <div class="checkbox-checked">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            @foreach($allPermissions->chunk(4) as $permissionsChunk)
                                            <tr>
                                                @foreach($permissionsChunk as $permission)
                                                <td style="width: 25%; padding: 5px; vertical-align: middle;">
                                                    <div class="input_outer" style="display: flex; align-items: center;">
                                                        <input
                                                            type="checkbox"
                                                            id="permission_{{ $permission->id }}"
                                                            name="permissions[]"
                                                            value="{{ $permission->id }}"
                                                            class="permission-checkbox"
                                                            {{ $permissions->contains($permission->id) ? 'checked' : '' }} style="margin-right: 8px;">
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
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editRoleBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#editRoleForm').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var data = new FormData(this);
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
                    $('#editRoleBtn').html('<span class="spinner-border spinner-border-sm"></span> Save ');
                    $('#editRoleBtn').attr('disabled', true);
                },
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'success') {
                        $('#editRoleBtn').html('Save');
                        $('#editRoleBtn').attr('disabled', false);
                        $('#editRoleModal').modal('hide');
                        toastr.success(result.message);
                        $('#role-table').DataTable().ajax.reload();
                    } else {
                        $('#editRoleBtn').html('Save');
                        $('#editRoleBtn').attr('disabled', false);
                        toastr.error(result.message);
                    }
                },
                error: function(error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors,
                        errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#editRoleBtn').html('Save');
                    $('#editRoleBtn').attr('disabled', false);
                }
            });
        }
    });
</script>