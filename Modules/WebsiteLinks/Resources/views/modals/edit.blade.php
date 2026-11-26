<div class="modal fade" id="editWebsiteLinks" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editWebsiteLinksLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title" id="editWebsiteLinksLabel">Edit Website Link</h5>
                <button type="button" class="btn-close py-0" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="editWebsiteLinkForm"
                  action="{{ route('manage.website.links.update', $websitelinks->id) }}"
                  method="POST">
                @method('PUT')

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- TITLE -->
                        <div class="col-12">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   value="{{ $websitelinks->title }}">
                            @component('components.ajax-error', ['field' => 'title'])@endcomponent
                        </div>

                        <div class="col-12">
                            <label class="form-label d-block">Link Type <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type_website" value="1" {{ $websitelinks->type == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_website">Website</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type_social_media" value="2" {{ $websitelinks->type == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_social_media">Social Media</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type_offer_page" value="3" {{ $websitelinks->type == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_offer_page">Offer Page</label>
                            </div>
                            @component('components.ajax-error', ['field' => 'type'])@endcomponent
                        </div>

                        <!-- LINK -->
                        <div class="col-12">
                            <label class="form-label">Link <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="link"
                                   class="form-control"
                                   value="{{ $websitelinks->link }}">
                            @component('components.ajax-error', ['field' => 'link'])@endcomponent
                        </div>

                        <div class="col-12">
                            <label class="form-label">Short Link</label>
                            <textarea name="short_link" class="form-control">
                                   {{ $websitelinks->short_link }}
                            </textarea>
                            @component('components.ajax-error', ['field' => 'short_link'])@endcomponent
                        </div>

                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="submit"
                            class="btn btn-outline-primary"
                            id="updateWebsiteLinkBtn">
                        <i class="fa fa-save"></i> Update Website Link
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>