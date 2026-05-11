<div class="modal fade" id="editSmsSetting" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit SMS Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="mt-2" id="updateSmsSettingForm">
                    @csrf
                    <input type="hidden" name="id" id="id">

                    @component('components.ajax-error',['field'=>'key'])@endcomponent
                    <div class="form-group">
                        <label>Sender ID:<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sender_id" id="sender_id">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'sender_id'])@endcomponent

                    <div class="form-group">
                        <label>Remarketing Sender ID:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="remarketing_sender_id" id="remarketing_sender_id">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'remarketing_sender_id'])@endcomponent

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary" id="doneBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
