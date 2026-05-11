<div class="modal fade" id="addDiseaseModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addDiseaseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDiseaseModalLabel">Add Disease</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addDiseaseForm" action="{{ route('manage.disease.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group">
                            <label for="name">Name<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                            @component('components.ajax-error', ['field' => 'name'])@endcomponent
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
                            @component('components.ajax-error', ['field' => 'description'])@endcomponent
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveDiseaseBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('stacks.js.disease.index')
