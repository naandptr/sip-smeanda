<div class="modal fade" id="modalAbsen" tabindex="-1" role="dialog" aria-labelledby="modalAbsen" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="formAbsen" action="{{ route('absen.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="tglAbsenFormatted">Tanggal</label>
                        <div class="modal-form-value">
                            <input type="text" id="tglAbsenView" readonly>
                            <input type="hidden" name="tglAbsenFormatted" id="tglAbsenFormatted">
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="jenisAbsen">Jenis<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="jenisAbsen" name="jenisAbsen" required>
                                <option value="Absen Datang">Presensi Datang</option>
                                <option value="Absen Pulang">Presensi Pulang</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="statusAbsen">Status<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="statusAbsen" name="statusAbsen" required>
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="ketAbsen">Keterangan<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <input type="text" id="ketAbsen" name="ketAbsen">
                        </div>
                        
                    </div>
                    <div class="modal-form-group">
                        <label for="fileAbsen">Unggah Foto<span class="required-label">*</span></h5></label>
                        <div class="modal-form-value">
                            <input type="file" class="filepond" name="fileAbsen" id="fileAbsen" required>
                        </div>
                    </div>
                </div>

                <div class="modal-form-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit" id="submitAbsen">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>