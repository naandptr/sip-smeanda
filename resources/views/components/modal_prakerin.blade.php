<div class="modal fade" id="modalPrakerin" tabindex="-1" aria-labelledby="modalPrakerin" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form action="/prakerin" method="POST" id="formPrakerin">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="namaSiswa">Nama Siswa<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="namaSiswa" name="namaSiswa" required>
                                <option>Arslan Allen</option>
                                <option>Patrick Star</option>
                                <option>Eugene</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="lokasiDUDI">Lokasi DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="lokasiDUDI" name="lokasiDUDI" required>
                                <option>PT. ABCD Animax Jaya</option>
                                <option>TVRI Jambi</option>
                                <option>Yadi Percetakan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="tglMulaiPrakerin">Tanggal Mulai<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="date" id="tglMulaiPrakerin" name="tglMulaiPrakerin">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="tglSelesaiPrakerin">Tanggal Selesai<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="date" id="tglSelesaiPrakerin" name="tglSelesaiPrakerin">
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
