<div class="modal fade" id="modalLokasi" tabindex="-1" aria-labelledby="modalLokasi" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form action="/lokasi" method="POST" id="formLokasi">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="namaDUDI">Nama DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="namaDUDI" name="namaDUDI">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="alamatDUDI">Alamat DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="alamatDUDI" name="alamatDUDI">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="bidangDUDI">Bidang Usaha<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="bidangDUDI" name="bidangDUDI">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="kuotaSiswa">Kuota Siswa<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="kuotaSiswa" name="kuotaSiswa">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="telpDUDI">Nomor Telepon<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="telpDUDI" name="telpDUDI">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="emailDUDI">Email DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="emailDUDI" name="emailDUDI">
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
