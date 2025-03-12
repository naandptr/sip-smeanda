<div class="modal fade" id="modalKelas" tabindex="-1" aria-labelledby="modalKelas" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form action="/kelas" method="POST" id="formKelas">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="namaKelas">Nama Kelas<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="namaKelas" name="namaKelas">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="namaJurusan">Jurusan<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="namaJurusan" name="namaJurusan" required>
                                <option>Animasi</option>
                                <option>Rekayasa Perangkat Lunak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="tahunAjar">Tahun Ajaran<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="tahunAjar" name="tahunAjar" required>
                                <option>2024/2025</option>
                                <option>2023/2024</option>
                                <option>2022/2023</option>
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
