<div class="modal fade" id="modalJurnal" tabindex="-1" aria-labelledby="modalJurnal" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form action="/jurnal" method="POST" id="formJurnal">
                <div class="modal-form-body">
                    <!-- Input Tanggal -->
                    <div class="modal-form-group">
                        <label for="tglJurnal">Tanggal<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="date" name="tglJurnal" id="tglJurnal" required>
                        </div>
                    </div>
                    <!-- Input Deskripsi -->
                    <div class="modal-form-group">
                        <label for="summernote">Deskripsi<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <textarea id="summernote" name="content" required></textarea>
                        </div>
                    </div>

                </div>
                <!-- Footer Modal -->
                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
