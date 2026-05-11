<div class="modal fade" id="editFacebookSetting" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Facebook Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="mt-2 updateSettingForm">
                    @csrf
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label>Facebook Domain Verification Id</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="domain_key" id="domain_key">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'domain_key'])@endcomponent
                    <div class="form-group">
                        <label>Facebook Event Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="event_name" id="event_name">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'event_name'])@endcomponent

                    <div class="form-group">
                        <label>Facebook Event Id</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="event_id" id="event_id">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'event_id'])@endcomponent

                    <div class="form-group">
                        <label>Facebook Pixel Key</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="pixel_key" id="pixel_key">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'pixel_key'])@endcomponent

                    <div class="form-group">
                        <label>Facebook Access Token</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="access_token" id="access_token">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'access_token'])@endcomponent

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary" id="doneBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
