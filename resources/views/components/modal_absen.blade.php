<div class="modal fade" id="modalAbsen" tabindex="-1" role="dialog" aria-labelledby="modalAbsen" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/absen" method="POST" id="formAbsen">
                <div class="modal-form-body">
                    <div class="modal-form-group">
                        <label for="tglAbsenFormatted">Tanggal</label>
                        <div class="modal-form-value">
                            <input type="text" name="tglAbsenFormatted" id="tglAbsenFormatted" readonly required>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="jenisAbsen">Jenis<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="jenisAbsen" name="jenisAbsen" required>
                                <option value="absen-datang">Absen Datang</option>
                                <option value="absen-pulang">Absen Pulang</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-form-group">
                        <label for="statusAbsen">Status<span class="required-label">*</span></label>
                        <div class="modal-form-value">
                            <select id="statusAbsen" name="statusAbsen" required>
                                <option value="status-hadir">Hadir</option>
                                <option value="status-izin">Izin</option>
                                <option value="status-sakit">Sakit</option>
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
                        <label for="fileAbsen">Upload Foto<span class="required-label">*</span></h5></label>
                        <div class="modal-form-value">
                            <input type="file" class="filepond" name="fileAbsen[]" id="fileAbsen">
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