<div class="modal fade" id="refundModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Refund Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('manage.refund.amount.process')}}" class="save-refund-form" id="save-refund-form" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="invoiceid" value="">
                    <div class="row g-3">
                        <div class="form-group">
                            <label>Invoice Number : <span id="invoiceNumberText"></span></label>
                        </div>
                        <div class="form-group">
                            <label>Payment Id<span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-air-primary" name="paymentid" id="paymentid" value="{{old('paymentid')}}" placeholder="Payment Id">
                            @component('components.ajax-error',['field'=>'paymentid'])@endcomponent
                        </div>
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea rows="5" class="form-control input-air-primary" name="remarks" id="remarks">{{old('remarks')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="banks-btn" class="btn btn-outline-primary">Refund Now</button>
                </div>
            </form>
        </div>
    </div>
</div>