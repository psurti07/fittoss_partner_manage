<div class="modal fade" id="editProductDetail" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title product-name"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="mt-2 updateProductForm">
                    @csrf
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label>Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="amount" id="amount">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'amount'])@endcomponent

                    <div class="form-group">
                        <label>Offer Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="offeramount" id="offeramount">
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'offeramount'])@endcomponent

                    <div class="form-group">
                        <label>In Offer? <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="inOffer" id="inOffer" class="form-control">
                                <option value="">Select</option>
                                <option value=1>Yes</option>
                                <option value=0>No</option>
                            </select>
                        </div>
                    </div>
                    @component('components.ajax-error',['field'=>'inOffer'])@endcomponent                

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary" id="doneBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
