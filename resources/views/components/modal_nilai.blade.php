<div class="modal fade" id="modalNilai" tabindex="-1" aria-labelledby="modalNilai" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form action="/" method="POST" id="formTambahNilai">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="tpValue">Tujuan Pembelajaran<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <textarea name="tpValue" id="tpValue" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="skorValue">Skor<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="skorValue" name="skorValue">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="descValue">Deskripsi<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <textarea name="descValue" id="descValue" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
