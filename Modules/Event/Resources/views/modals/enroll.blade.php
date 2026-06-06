<div class="modal fade" id="enrollModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="enrollForm" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="event_user_id" id="event_user_id">

                <div class="modal-header">
                    <h5 class="modal-title">Enroll User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Reference ID <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="ref_id" id="ref_id">
                        </div>
                        @component('components.ajax-error',['field'=>'ref_id'])@endcomponent
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="amount" id="amount" step="any">
                        </div>
                        @component('components.ajax-error',['field'=>'amount'])@endcomponent
                    </div>


                    <div class="form-group">
                        <label>Points</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="points" id="points" step="any">
                        </div>
                        @component('components.ajax-error',['field'=>'points'])@endcomponent
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary" id="doneBtn">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>
