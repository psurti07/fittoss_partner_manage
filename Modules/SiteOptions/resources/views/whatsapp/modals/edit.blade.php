<div class="modal fade" id="editWhatsappSetting" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Whatsapp Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="mt-2" id="updateWhatsappSettingForm">
                    @csrf
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label>Key:<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="key" id="key">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'key'])@endcomponent
                    <div class="form-group">
                        <label>Template Name:<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="template_name" id="template_name">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'template_name'])@endcomponent

                    <div class="form-group">
                        <label>Media Name:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="media_name" id="media_name">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'media_name'])@endcomponent

                    <div class="form-group">
                        <label>Media URL:</label>
                        <div class="input-group">
                            <textarea class="form-control" name="media_url" id="media_url" rows="5"></textarea>
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'media_url'])@endcomponent

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary" id="doneBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
