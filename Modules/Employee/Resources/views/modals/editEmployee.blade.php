<div class="modal fade" id="editEmployee" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manage.employee.update', ['id' => $data['id']]) }}" class="update-employee-form" id="update-employee-form" method="post">
                <div class="modal-body">
                    <!-- <input type="hidden" name="id" value="{{$data['id']}}"> -->
                    <div class="row">

                        <div class="form-group col-md-6 mb-3">
                            <label>Employee Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-air-primary" name="name" id="name" value="{{ $data['name'] }}" placeholder="John Doe">
                            @component('components.ajax-error',['field'=>'name'])@endcomponent
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Employee Mobile No<span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-air-primary" name="mobile_no" id="mobile_no" value="{{ $data['mobile_no'] }}" placeholder="+91 9876543210" minlength="10" maxlength="10">
                            @component('components.ajax-error',['field'=>'mobile_no'])@endcomponent
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Employee EmailId<span class="text-danger">*</span></label>
                            <input type="email" class="form-control input-air-primary" name="email" id="email" value="{{ $data['email'] }}" placeholder="john@doe.com">
                            @component('components.ajax-error',['field'=>'email'])@endcomponent
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Employee Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control input-air-primary" name="password" id="password" placeholder="abc@123">
                            <i class="icon-eye password-eye" data-target="password" style="position: absolute; top: 39px; right: 15px; cursor: pointer; font-size: 1.0rem;"></i>
                            @component('components.ajax-error',['field'=>'password'])@endcomponent
                        </div>
                        
                        <div class="form-group col-md-6 mb-3">
                            <label>Department<span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-air-primary" name="department" id="department" value="{{ $data['department'] }}" placeholder="Sales">
                            @component('components.ajax-error',['field'=>'department'])@endcomponent
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Date of Birth<span class="text-danger">*</span></label>
                            <input type="date" class="form-control input-air-primary" name="dob" id="dob" value="{{ $data['dob'] }}" placeholder="Enter Employee's DOB">
                            @component('components.ajax-error',['field'=>'dob'])@endcomponent
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Date of Joining<span class="text-danger">*</span></label>
                            <input type="date" class="form-control input-air-primary" name="doj" id="doj" value="{{ $data['doj'] }}" placeholder="Enter Employee's Date of Joining">
                            @component('components.ajax-error',['field'=>'doj'])@endcomponent
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label>Resign Date</label>
                            <div class="input-group">
                                <input type="date" class="form-control input-air-primary" name="resign_date" id="resign_date" value="{{ $data['resign_date'] }}">
                                <button class="btn btn-outline-secondary" type="button" id="clear-resign-date">Clear</button>
                            </div>
                            @component('components.ajax-error',['field'=>'resign_date'])@endcomponent
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="employee-btn" class="btn btn-outline-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.update-employee-form').submit(function(event) {
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
                beforeSend: function(){
                    $('#employee-btn').html('<span class="spinner-border spinner-border-sm"></span> Update');
                    $('#employee-btn').attr('disabled', true);
                },
                success: function(result) {
                    $('#employee-btn').attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#editEmployee').modal('hide');
                        $('#employee-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                        $('#employee-btn').html('Update');
                        $('#employee-btn').attr('disabled', false);
                    }
                },
                error: function(error) {
                    $('#employee-btn').attr("disabled", false);
                    let errors = error.responseJSON.errors,
                        errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#employee-btn').html('Update');
                    $('#employee-btn').attr('disabled', false);
                }
            });
        }
    });

    $(document).ready(function () {
        $("#mobile_no").on("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    });

    //show password through Eye icon
    document.querySelectorAll('.password-eye').forEach(icon => {
        let inputId = icon.getAttribute('data-target');
        let input = document.getElementById(inputId);

        icon.addEventListener('mousedown', () => {
            input.type = 'text';
        });

        icon.addEventListener('mouseup', () => {
            input.type = 'password';
        });

        icon.addEventListener('mouseleave', () => {
            input.type = 'password';
        });
    });

    $(document).on("click", "#clear-resign-date", function() {
        $("#resign_date").val("");
    });
</script>
