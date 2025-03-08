<div class="modal fade" id="modalJurnal" tabindex="-1" role="dialog" aria-labelledby="modalTambahJurnal" aria-hidden="true">
    <div class="modal-dialog custom-modal" role="document">
        <div class="modal-content modal-jurnal-content">
            <form action="/jurnal" method="POST" class="jurnal-form" id="formJurnal">
                <div class="modal-jurnal-body">
                    <div class="input-item">
                        <label for="tglJurnal">Tanggal<span style="color: red;">*</span></label>
                        <div class="input-value">
                            <input type="date" name="tglJurnal" id="tglJurnal" required>
                        </div>
                    </div>
                    <div class="input-item">
                        <label for="summernote">Deskripsi<span style="color: red;">*</span></label>
                        <div class="input-value">
                            <textarea id="summernote" name="content"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-jurnal-footer" id="modalFooter">
                    <button type="button" class="close btn-cancel" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    <button type="submit" class="btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>