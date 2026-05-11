<div class="modal fade" id="addAccounts" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Accounts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.staff.account.store')}}" class="save-accounts-form" id="save-accounts-form" method="post">
                <input type="hidden" value="{{ date('Y-m-d H:i:s') }}" name="rec_date">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="role">Role<span class="text-danger">*</span></label>
                                <select class="form-control form-select" name="role" id="role">
                                    <option value="">Select Role</option>
                                    <option value="1">Office Staff</option>
                                    <option value="2">IVR/Support Staff</option>
                                    <option value="3">IT Staff</option>
                                </select>
                                @component('components.ajax-error',['field'=>'role'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="fullname">Fullname<span class="text-danger">*</span></label>
                                <input type="text" name="fullname" class="form-control" placeholder="Fullname" id="fullname" value="{{old('fullname')}}">
                                @component('components.ajax-error',['field'=>'fullname'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="email">Email Id<span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email" id="email" value="{{old('email')}}" autocomplete="off">
                                @component('components.ajax-error',['field'=>'email'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="mobile">Mobile<span class="text-danger">*</span></label>
                                <input type="text" maxlength="10" minlength="10" inputmode="numeric" name="mobile" class="form-control" placeholder="Mobile no" id="mobile" value="{{old('mobile')}}">
                                @component('components.ajax-error',['field'=>'mobile'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="password">Password<span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Password" id="password" value="{{old('password')}}" autocomplete="off">
                                @component('components.ajax-error',['field'=>'password'])@endcomponent
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="retypepassword">Retype Password<span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype Password" id="retypepassword" value="{{old('retypepassword')}}">
                                @component('components.ajax-error',['field'=>'retypepassword'])@endcomponent
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="fw-bold fs-3" id="textpswd"></label>
                            <button class="btn btn-warning btn-sm" id="generate" type="button">Generate Password</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="account-btn" class="btn btn-outline-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.save-accounts-form').submit(function (event) {
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
                beforeSend:function(){
                    $('#account-btn').html('<span class="spinner-border spinner-border-sm"></span> Add');
                    $('#account-btn').attr('disabled', true);
                },
                success: function (result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#addAccounts').modal('hide');
                        $('#staffaccount-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                        $('#account-btn').html('Add');
                        $('#account-btn').attr('disabled', false);
                    }
                },
                error: function (error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors, errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                    $('#account-btn').html('Add');
                    $('#account-btn').attr('disabled', false);
                }
            });
        }
    });
    document.getElementById('generate').addEventListener('click', function() {
        let password = Math.floor(100000 + Math.random() * 900000);
        document.getElementById('password').value = password;
        document.getElementById('retypepassword').value = password;
        document.getElementById('textpswd').textContent = password;
    });
    $(document).ready(function () {
        $("#mobile").on("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    });
</script>
