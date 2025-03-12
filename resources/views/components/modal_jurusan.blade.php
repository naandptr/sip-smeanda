<div class="modal fade" id="modalJurusan" tabindex="-1" aria-labelledby="modalJurusan" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form action="/jurusan" method="POST" id="formJurusan">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="kodeJurusan">Kode Jurusan<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="kodeJurusan" name="kodeJurusan">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="namaJurusan">Nama Jurusan<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="namaJurusan" name="namaJurusan">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="statusJurusan">Status<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="statusJurusan" name="statusJurusan" required>
                                <option>Aktif</option>
                                <option>Nonaktif</option>
                            </select>
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
