<div class="modal fade" id="modalAbsen" tabindex="-1" role="dialog" aria-labelledby="modalTambahAbsen" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-absen-content">
            <form action="/absen" method="POST" class="absen-form" id="formAbsen">
                <div class="modal-absen-body">
                    <div class="input-item">
                        <label for="tglAbsenFormatted">Tanggal</label>
                        <div class="input-value">
                            <input type="text" name="tglAbsenFormatted" id="tglAbsenFormatted" readonly required>
                        </div>
                    </div>
                    <div class="input-item">
                        <label for="jenisAbsen">Jenis<span style="color: red;">*</span></label>
                        <div class="input-value">
                            <select id="jenisAbsen" name="jenisAbsen" required>
                                <option value="absen-datang">Absen Datang</option>
                                <option value="absen-pulang">Absen Pulang</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-item">
                        <label for="statusAbsen">Status<span style="color: red;">*</span></label>
                        <div class="input-value">
                            <select id="statusAbsen" name="statusAbsen" required>
                                <option value="status-hadir">Hadir</option>
                                <option value="status-izin">Izin</option>
                                <option value="status-sakit">Sakit</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-item">
                        <label for="ketAbsen">Keterangan<span style="color: red;">*</span></label>
                        <div class="input-value">
                            <input type="text" id="ketAbsen" name="ketAbsen">
                        </div>
                        
                    </div>
                    <div class="input-item">
                        <label for="fileAbsen">Upload Foto<span style="color: red;">*</span></h5></label>
                        <div class="input-value">
                            <input type="file" class="filepond" name="fileAbsen[]" id="fileAbsen">
                        </div>
                    </div>
                </div>

                <div class="modal-absen-footer">
                    <button type="button" class="close btn-cancel" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    <button type="submit" class="btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>