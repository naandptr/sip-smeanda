@props(['dudi', 'pembimbing' 'tahunAjar'])
<div class="modal fade" id="modalDudiJurusan" tabindex="-1" aria-labelledby="modalDudiJurusan" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <form action="/dudi" method="POST" id="formDudiJurusan">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="lokasiDUDI">Penetapan DUDI<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="lokasiDUDI" name="lokasiDUDI" required>
                                <option>PT. ABCD Animax Jaya</option>
                                <option>TVRI Jambi</option>
                                <option>Yadi Percetakan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="namaPembimbing">Nama Pembimbing<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="namaPembimbing" name="namaPembimbing" required>
                                <option>Siti Menenun</option>
                                <option>Mulyono</option>
                                <option>Panjar Granowo</option>
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
