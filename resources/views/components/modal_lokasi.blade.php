<div class="modal fade" id="modalLokasi" tabindex="-1" aria-labelledby="modalLokasi" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form id="formLokasi" method="POST" action="{{ isset($lokasi) ? route('lokasi.update', $lokasi->id) : route('lokasi.store') }}">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="namaDudi">Nama DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="namaDudi" name="namaDudi">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="alamatDudi">Alamat DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="alamatDudi" name="alamatDudi">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="bidangDudi">Bidang Usaha<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="bidangDudi" name="bidangDudi">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="telpDudi">Nomor Telepon<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="telpDudi" name="telpDudi">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="emailDudi">Email DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="emailDudi" name="emailDudi">
                        </div>
                    </div>
                </div>
                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit" id="submitLokasi">Simpan</button>
                    <button type="submit" class="btn-submit" id="updateLokasi">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
