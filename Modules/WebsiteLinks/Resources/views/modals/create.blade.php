<div class="modal fade" id="addWebsiteLinks" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addWebsiteLinksLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title" id="addWebsiteLinksLabel">Add Website Link</h5>
                <button type="button" class="btn-close py-0" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="addWebsiteLinkForm" action="{{ route('manage.website.links.store') }}" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- TITLE -->
                        <div class="col-12">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="Graphic AMC">
                            <small class="text-danger ajax-error title"></small>
                        </div>

                        <!-- LINK -->
                        <div class="col-12">
                            <label class="form-label">Link <span class="text-danger">*</span></label>
                            <input type="text" name="link" class="form-control" placeholder="https://example.com">
                            <small class="text-danger ajax-error link"></small>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Short Link</label>
                            <textarea name="short_link" class="form-control" placeholder="https://example.com"></textarea>
                            <small class="text-danger ajax-error short_link"></small>
                        </div>

                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success" id="saveWebsiteLinkBtn">
                        <i class="fa fa-plus"></i> Create Website Link
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>