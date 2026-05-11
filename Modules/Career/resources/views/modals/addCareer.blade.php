<div class="modal fade" id="addCareerModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addCareerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCareerModalLabel">Add Career</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addCareerForm" action="{{ route('manage.career.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group">
                            <label for="title">Title<span class="txt-danger">*</span></label>
                            <input type="text" class="form-control" id="title" placeholder="Title" name="title">
                            @component('components.ajax-error', ['field' => 'title'])@endcomponent
                        </div>
                        <div class="col-12 form-group">
                            <label for="career_content">Description<span class="text-danger">*</span></label>
                            <textarea id="career_content" name="description" cols="10" rows="5" class=""></textarea>
                            @component('components.ajax-error', ['field' => 'career_content'])@endcomponent
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveCareerBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('stacks.js.career.index')
